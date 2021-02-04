<?php
include 'main.php';
class ChordTest  extends \PHPUnit\Framework\TestCase{

    public function testChordClassified() {

        $global_data_repo = new GlobalDataRepository();
        $song_chords_data = $global_data_repo->getAllSongChordData();
        foreach ($song_chords_data as $song_name => $song_data) {
            train($song_data['chords'], $song_data['label']);
        }

        setLabelProbabilities();
        setChordCountsInLabels();
        setProbabilityOfChordsInLabels();
        [$ttal1, $classified1] = classify(['d', 'g', 'e', 'dm']);
        [$ttal2, $classified2] = classify(['f#m7', 'a', 'dadd9', 'dmaj7', 'bm', 'bm7', 'd', 'f#m']);
        $this->assertEquals($ttal1, [
            'easy' => 0.33333333333333,
            'medium' => 0.33333333333333,
            'hard' => 0.33333333333333,
        ]);
        $this->assertEquals($classified1, [
            'easy' => 2.0230948271605,
            'medium' => 1.8557586131687,
            'hard' => 1.8557586131687,
        ]);
        $this->assertEquals($ttal2, [
            'easy' => 0.33333333333333,
            'medium' => 0.33333333333333,
            'hard' => 0.33333333333333,
        ]);
        $this->assertEquals($classified2, [
            'easy' => 1.3433333333333,
            'medium' => 1.5060259259259,
            'hard' => 1.688422399177,
        ]);
    }
}
