<?php


class GlobalDataRepository
{
    private $song_chords = [
        'imagine' => [
            'chords'    =>  ['c', 'cmaj7', 'f', 'am', 'dm', 'g', 'e7'],
            'label'     =>  'easy'
        ],
        'somewhere_over_the_rainbow' => [
            'chords'    =>  ['c', 'em', 'f', 'g', 'am'],
            'label'     =>  'easy'
        ],
        'tooManyCooks' => [
            'chords'    =>  ['c', 'g', 'f'],
            'label'     =>  'easy'
        ],
        'iWillFollowYouIntoTheDark' => [
            'chords'    =>  ['f', 'dm', 'bb', 'c', 'a', 'bbm'],
            'label'     =>  'medium'
        ],
        'babyOneMoreTime' => [
            'chords'    =>  ['cm', 'g', 'bb', 'eb', 'fm', 'ab'],
            'label'     =>  'medium'
        ],
        'creep' => [
            'chords'    =>  ['g', 'gsus4', 'b', 'bsus4', 'c', 'cmsus4', 'cm6'],
            'label'     =>  'medium'
        ],
//        'army' => [
//            'chords'    =>  ['ab', 'ebm7', 'dbadd9', 'fm7', 'bbm', 'abmaj7', 'ebm'],
//            'label'     =>  'medium'
//        ],
        'paperBag' => [
            'chords'    =>  ['bm7', 'e', 'c', 'g', 'b7', 'f', 'em', 'a', 'cmaj7', 'em7', 'a7', 'f7', 'b'],
            'label'     =>  'hard'
        ],
        'toxic' => [
            'chords'    =>  ['cm', 'eb', 'g', 'cdim', 'eb7', 'd7', 'db7', 'ab', 'gmaj7', 'g7'],
            'label'     =>  'hard'
        ],
        'bulletproof' => [
            'chords'    =>  ['d#m', 'g#', 'b', 'f#', 'g#m', 'c#'],
            'label'     =>  'hard'
        ],
    ];

    public function getAllSongChordData()
    {
        return $this->song_chords;
    }
}