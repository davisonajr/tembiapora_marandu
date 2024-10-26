<?php

namespace App\Services;

use TextAnalysis\Analysis\FreqDist;
use TextAnalysis\Filters\LowerCaseFilter;
use TextAnalysis\Filters\PunctuationFilter;
use TextAnalysis\Filters\QuotesFilter;
use TextAnalysis\Filters\StopWordsFilter;
use TextAnalysis\Filters\UrlFilter;
use TextAnalysis\Tokenizers\GeneralTokenizer;

class TextAnalysisService
{
    public function calculateWordFrequency($text, $lang)
    {
        // Tokenizar o texto
        $tokens = tokenize($text, \TextAnalysis\Tokenizers\WhitespaceTokenizer::class);

        $stopwords = $lang == 'pt' ? $this->getPTStopWords() : $this->getESStopWords();

        filter_stopwords($tokens,$stopwords);

        $tokens = normalize_tokens($tokens); 

        $freqDist = freq_dist($tokens);
        $totalTokens = count($tokens);

        $relativeFrequencies = [];

        foreach ($freqDist->getKeyValuesByFrequency() as $word => $frequency) {
            $relativeFrequencies[$word] = $frequency / $totalTokens;
        }

        return $relativeFrequencies;
    }

    /** 
    *
    * @returns array The array is empty if the stop words file does not exist
    */
    static public function getPTStopWords()
    {
        $stopwords = [];
	    $path = realpath(public_path('/stopwords/pt_1.txt'));

        if(file_exists($path)) { 
            $stopwords = array_map('trim', file($path));
        }

        $path = realpath(public_path('/stopwords/pt_2.txt'));
        if(file_exists($path)) { 
            $stopwords = array_merge($stopwords, array_map('trim', file($path)));
        }

        $path = realpath(public_path('/stopwords/pt_BR.txt'));
        if(file_exists($path)) { 
            $stopwords = array_merge($stopwords, array_map('trim', file($path)));
        }
        return array_unique($stopwords);
    }

    /** 
    *
    * @returns array The array is empty if the stop words file does not exist
    */
    static public function getESStopWords()
    {
        $stopwords = [];
	    $path = realpath(public_path('/stopwords/es_1.txt'));

        if(file_exists($path)) { 
            $stopwords = array_map('trim', file($path));
        }

        $path = realpath(public_path('/stopwords/es_2.txt'));
        if(file_exists($path)) { 
            $stopwords = array_merge($stopwords, array_map('trim', file($path)));
        }

        return array_unique($stopwords);
    }
}