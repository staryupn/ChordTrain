<?php
require 'global_data.php';

// songs
$imagine = ['c', 'cmaj7', 'f', 'am', 'dm', 'g', 'e7'];
$somewhere_over_the_rainbow = ['c', 'em', 'f', 'g', 'am'];
$tooManyCooks = ['c', 'g', 'f'];
$iWillFollowYouIntoTheDark = ['f', 'dm', 'bb', 'c', 'a', 'bbm'];
$babyOneMoreTime = ['cm', 'g', 'bb', 'eb', 'fm', 'ab'];
$creep = ['g', 'gsus4', 'b', 'bsus4', 'c', 'cmsus4', 'cm6'];
$army = ['ab', 'ebm7', 'dbadd9', 'fm7', 'bbm', 'abmaj7', 'ebm'];
$paperBag = ['bm7', 'e', 'c', 'g', 'b7', 'f', 'em', 'a', 'cmaj7', 'em7', 'a7', 'f7', 'b'];
$toxic = ['cm', 'eb', 'g', 'cdim', 'eb7', 'd7', 'db7', 'ab', 'gmaj7', 'g7'];
$bulletproof = ['d#m', 'g#', 'b', 'f#', 'g#m', 'c#'];
$song_11 = [];
$songs = [];
$labels = [];
$allChords = [];
$labelCounts = [];
$labelProbabilities = [];
$chordCountsInLabels = [];
$probabilityOfChordsInLabels = [];

function train($chords, $label)
{
    $GLOBALS['songs'][] = [$label, $chords];
    $GLOBALS['label'][] = $label;
    $GLOBALS['allChords'] = getUniqueChords($chords, $GLOBALS['allChords']);
    $GLOBALS['labelCounts'] = updateLabelCounts($label, $GLOBALS['labelCounts']);
}

/**
 * @param $chords
 * @param $current_all_chords
 * @return array
 */
function getUniqueChords($chords, $current_all_chords)
{
    $all_chords = [];
    for ($i = 0; $i < count($chords); $i++) {
        if (!in_array($chords[$i], $current_all_chords)) {
            $all_chords[] = $chords[$i];
        }
    }

    return $all_chords;
}

/**
 * @param $label
 * @param $label_counts
 * @return mixed
 */
function updateLabelCounts($label, $label_counts)
{
    if (!!(in_array($label, array_keys($label_counts)))) {
        $label_counts[$label] = $label_counts[$label] + 1;
    } else {
        $label_counts[$label] = 1;
    }

    return $label_counts;
}

function getNumberOfSongs()
{
    return count($GLOBALS['songs']);
}

function setLabelProbabilities()
{
    foreach (array_keys($GLOBALS['labelCounts']) as $label) {
        $numberOfSongs = getNumberOfSongs();
        $GLOBALS['labelProbabilities'][$label] = $GLOBALS['labelCounts'][$label] / $numberOfSongs;
    }
}

function setChordCountsInLabels()
{
    foreach ($GLOBALS['songs'] as $i) {
        if (!isset($GLOBALS['chordCountsInLabels'][$i[0]])) {
            $GLOBALS['chordCountsInLabels'][$i[0]] = [];
        }
        foreach ($i[1] as $j) {
            if ($GLOBALS['chordCountsInLabels'][$i[0]][$j] > 0) {
                $GLOBALS['chordCountsInLabels'][$i[0]][$j] = $GLOBALS['chordCountsInLabels'][$i[0]][$j] + 1;
            } else {
                $GLOBALS['chordCountsInLabels'][$i[0]][$j] = 1;
            }
        }
    }
}

function setProbabilityOfChordsInLabels()
{
    $GLOBALS['probabilityOfChordsInLabels'] = $GLOBALS['chordCountsInLabels'];
    foreach (array_keys($GLOBALS['probabilityOfChordsInLabels']) as $i) {
        foreach (array_keys($GLOBALS['probabilityOfChordsInLabels'][$i]) as $j) {
            $GLOBALS['probabilityOfChordsInLabels'][$i][$j] = $GLOBALS['probabilityOfChordsInLabels'][$i][$j] * 1.0 / getNumberOfSongs();
        }
    }
}

$global_data_repo = new GlobalDataRepository();
$song_chords_data = $global_data_repo->getAllSongChordData();
foreach ($song_chords_data as $song_name => $song_data) {
    train($song_data['chords'], $song_data['label']);
}

setLabelProbabilities();
setChordCountsInLabels();
setProbabilityOfChordsInLabels();

function classify($chords){
    $ttal = $GLOBALS['labelProbabilities'];
    $classified = [];
    foreach (array_keys($ttal) as $obj) {
        $first = $GLOBALS['labelProbabilities'][$obj] + 1.01;
        foreach ($chords as $chord) {
            $probabilityOfChordInLabel = $GLOBALS['probabilityOfChordsInLabels'][$obj][$chord];
            if (!isset($probabilityOfChordInLabel)) {
                $first + 1.01;
            } else {
                $first = $first * ($probabilityOfChordInLabel + 1.01);
            }
            $classified[$obj] = $first;
        }
    }

    return [$ttal, $classified];
}

[$ttal, $classified] = classify(['d', 'g', 'e', 'dm']);
standardOuputClassifieds($ttal, $classified);
[$ttal, $classified] = classify(['f#m7', 'a', 'dadd9', 'dmaj7', 'bm', 'bm7', 'd', 'f#m']);
standardOuputClassifieds($ttal, $classified);
/**
 * @param $ttal
 * @param $classified
 */
function standardOuputClassifieds($ttal, $classified): void
{
    print_r($ttal);
    print_r($classified);
}