<script src='options.js'></script>
<script src='fretboard.js'></script>
<h2>Positions absolues</h2>
<?php
$div ="fboard";
print("<div id='$div'>\n");
print("</div>\n");
print("<br/><br/>\n");
?>
<?php
$notes = [ "A", "A#/Bb", "B", "C", "C#/Db", "D", "D#/Eb", "E", "F", "F#/Gb", "G", "G#/Ab" ];
$chords = json_decode('[
    {"sym":"",      "lsym":"", 			"root":0, "third":4, "fifth":7, "added":"",     "name":"major", "alt":"", "type":"triad"},
    {"sym":"m",     "lsym":"min",       "root":0, "third":3, "fifth":7, "added":"",     "name":"minor", "alt":"", "type":"triad"},
    {"sym":"+",     "lsym":"aug",       "root":0, "third":4, "fifth":8, "added":"",     "name":"augmented", "alt":"", "type":"triad"},
    {"sym":"-",     "lsym":"dim",       "root":0, "third":3, "fifth":6, "added":"",     "name":"diminished", "alt":"", "type":"triad"},
    {"sym":"6",     "lsym":"",          "root":0, "third":4, "fifth":7, "added":9,      "name":"major sixth", "alt":"", "type":"tetrad"},
    {"sym":"m6",    "lsym":"min6",      "root":0, "third":3, "fifth":7, "added":9,      "name":"minor sixth", "alt":"", "type":"tetrad"},
    {"sym":"7",     "lsym":"dom7",      "root":0, "third":4, "fifth":7, "added":10,     "name":"seventh", "alt":"dominant seventh", "type":"tetrad"},
    {"sym":"M7",    "lsym":"maj7",      "root":0, "third":4, "fifth":7, "added":11,     "name":"major seventh", "alt":"", "type":"tetrad"},
    {"sym":"mM7",   "lsym":"min maj7",  "root":0, "third":3, "fifth":7, "added":11,     "name":"minor major seventh", "alt":"", "type":"tetrad"},
    {"sym":"m7",    "lsym":"min7",      "root":0, "third":3, "fifth":7, "added":10,     "name":"minor seventh", "alt":"minor seventh chord", "type":"tetrad"},
    {"sym":"+M7",   "lsym":"aug maj7",  "root":0, "third":4, "fifth":8, "added":11,     "name":"augmented major seventh", "alt":"major seventh sharp five", "type":"tetrad"},
    {"sym":"+7",    "lsym":"aug7",      "root":0, "third":4, "fifth":8, "added":10,     "name":"augmented seventh", "alt":"dominant senveth five sharp", "type":"tetrad"},
    {"sym":"-7",    "lsym":"dim7",      "root":0, "third":3, "fifth":6, "added":9,      "name":"diminieshed seventh", "alt":"", "type":"tetrad"},
    {"sym":"ø",    	"lsym":"ø7",        "root":0, "third":3, "fifth":6, "added":10,     "name":"half diminishd seventh", "alt":"minor seventh flat five", "type":"tetrad"}
]');

$chorddict = json_decode('[ 
    { "name": "Major",              "sym": "",              "intervals": [0, 4, 7] },
    { "name": "Major b5th",         "sym": "(-5)",          "intervals": [0, 4, 6] },
    { "name": "minor",              "sym": "m",             "intervals": [0, 3, 7] },
    { "name": "minor(+5)",          "sym": "m(+5)",         "intervals": [0, 3, 8] },
    { "name": "augmented 5th",      "sym": "aug5",          "intervals": [0, 4, 8] },
    { "name": "diminished 5th",     "sym": "dim5",          "intervals": [0, 3, 6] },
    { "name": "suspended 4th",      "sym": "sus4",          "intervals": [0, 5, 7] },
    { "name": "aug 5th sus 4th",    "sym": "aug5sus4",      "intervals": [0, 5, 8] },
    { "name": "dim 5th sus 4th",    "sym": "dim5sus4",      "intervals": [0, 5, 6] },
    { "name": "suspended 2nd",      "sym": "sus2",          "intervals": [0, 2, 7] },
    { "name": "aug 5th sus 2nd",    "sym": "aug5sus2",      "intervals": [0, 2, 8] },
    { "name": "dim 5th sus 2dn",    "sym": "dim5sus2",      "intervals": [0, 2, 6] },
    { "name": "6th",                "sym": "6",             "intervals": [0, 4, 7,  9] },
    { "name": "7th",                "sym": "7",             "intervals": [0, 4, 7, 10] },
    { "name": "Maj 7th",            "sym": "M7",            "intervals": [0, 4, 7, 11] },
    { "name": "Added 9th",          "sym": "add9",          "intervals": [0, 2, 4,  7] },
    { "name": "Added 11th",         "sym": "add11",         "intervals": [0, 4, 5,  7] },
    { "name": "6th b5th",           "sym": "6(-5)",         "intervals": [0, 4, 6,  9] },
    { "name": "7th b5th",           "sym": "7(-5)",         "intervals": [0, 4, 6, 10] },
    { "name": "Maj 7th b5th",       "sym": "M7(-5)",        "intervals": [0, 4, 6, 11] },
    { "name": "minor b6th",         "sym": "m(-6)",         "intervals": [0, 3, 7,  8] },
    { "name": "minor 6th",          "sym": "m6",            "intervals": [0, 3, 7,  9] },
    { "name": "minor 7th",          "sym": "m7",            "intervals": [0, 3, 7, 10] },
    { "name": "minor Maj 7th",      "sym": "mM7",           "intervals": [0, 3, 7, 11] },
    { "name": "minor add b9th",     "sym": "madd (-9)",     "intervals": [0, 1, 3,  7] },
    { "name": "minor add 9th",      "sym": "madd9",         "intervals": [0, 2, 3,  7] },
    { "name": "minor add 11th",     "sym": "m add11",       "intervals": [0, 3, 6,  7] },
    { "name": "aug 5th / 7th",      "sym": "aug5/7",        "intervals": [0, 4, 8, 10] },
    { "name": "aug 5th Maj 7th",    "sym": "aug5M7",        "intervals": [0, 4, 8, 11] },
    { "name": "aug 5th add 9th",    "sym": "aug5 add9",     "intervals": [0, 2, 4,  8] },
    { "name": "diminished [7th]",   "sym": "dim7",          "intervals": [0, 3, 6,  9] },
    { "name": "dim 5th / 7th",      "sym": "dim5/7",        "intervals": [0, 3, 6, 10] },
    { "name": "dim 5th add 9th",    "sym": "dim5 add9",     "intervals": [0, 2, 3,  6] },
    { "name": "b6th sus 4th",       "sym": "(-6)sus4",      "intervals": [0, 6, 7,  8] },
    { "name": "6th sus 4th",        "sym": "6sus4",         "intervals": [0, 5, 7,  9] },
    { "name": "7th sus 4th",        "sym": "7sus4",         "intervals": [0, 5, 7, 10] },
    { "name": "Maj7th sus 4th",     "sym": "M7sus4",        "intervals": [0, 4, 7, 11] },
    { "name": "sus 4th add b9th",   "sym": "sus4add(-9)",   "intervals": [0, 1, 4,  7] },
    { "name": "sus 4th add 9th",    "sym": "sus4add9",      "intervals": [0, 2, 4,  7] },
    { "name": "flat6th sus 2nd",    "sym": "(-6)sus2",      "intervals": [0, 2, 7,  8] },
    { "name": "6th sus 2nd",        "sym": "6sus2",         "intervals": [0, 2, 7,  9] },
    { "name": "7th sus 2nd",        "sym": "7sus2",         "intervals": [0, 2, 7, 10] },
    { "name": "Maj 7th sus 2nd",    "sym": "M7sus2",        "intervals": [0, 2, 7, 11] },
    { "name": "Maj 7th sus 2nd",    "sym": "M7sus2",        "intervals": [0, 2, 7, 11] },
	{ "name": "6th add 9th",          "sym": "6add9",        "intervals": [0, 2, 4, 7,  9]},
	{ "name": "6th add 11th",         "sym": "6add11",       "intervals": [0, 4, 5, 7,  9]},
	{ "name": "[7th add] 9th",        "sym": "7add9",        "intervals": [0, 2, 4, 7, 10]},
	{ "name": "7th add 11th",         "sym": "7add11",       "intervals": [0, 4, 5, 7, 10]},
	{ "name": "7th add 13th",         "sym": "7add13",       "intervals": [0, 4, 7, 9, 10]},
	{ "name": "Maj [7th add] 9th",    "sym": "M7add9",       "intervals": [0, 2, 4, 7, 11]},
	{ "name": "Maj 7th add 11th",     "sym": "M7add11",      "intervals": [0, 4, 5, 7, 11]},
	{ "name": "Maj 7th add 13th",     "sym": "M7add13",      "intervals": [0, 4, 7, 9, 11]},
	{ "name": "6th flat5 add 9*",     "sym": "6(-5)add9",    "intervals": [0, 2, 4, 6,  9]},
	{ "name": "M7th flat5 add9*",     "sym": "M7(-5)add9",   "intervals": [0, 2, 4, 6, 11]},
	{ "name": "M7th flat5 add13*",    "sym": "M7(-5)add13",  "intervals": [0, 4, 6, 9, 11]},
	{ "name": "min 6th add 9th",      "sym": "min6add9",     "intervals": [0, 2, 3, 7,  9]},
	{ "name": "min 6th add 11th",     "sym": "min6add11",    "intervals": [0, 3, 5, 7,  9]},
	{ "name": "min [7th add] 9th",    "sym": "min7add9",     "intervals": [0, 2, 3, 7, 10]},
	{ "name": "min 7th add 11th",     "sym": "min7add11",    "intervals": [0, 3, 5, 7, 10]},
	{ "name": "min 7th add 13th",     "sym": "min7add13",    "intervals": [0, 3, 7, 9, 10]},
	{ "name": "min M7 add 9th",       "sym": "min M7add9",   "intervals": [0, 2, 3, 7, 11]},
	{ "name": "min M7 add 11th",      "sym": "min M7add11",  "intervals": [0, 3, 5, 7, 11]},
	{ "name": "min M7 add 13th",      "sym": "min M7add13",  "intervals": [0, 3, 7, 9, 11]},
	{ "name": "aug5/ 7th add 9th*",   "sym": "aug5/7add9",   "intervals": [0, 2, 4, 8, 10]},
	{ "name": "aug5/ 7th add 11th*",  "sym": "aug5/7add11",  "intervals": [0, 4, 5, 8, 10]},
	{ "name": "aug5/ 7th add13th*",   "sym": "aug5/7add13",  "intervals": [0, 4, 8, 9, 10]},
	{ "name": "dim5/ 7th add 9th*",   "sym": "dim5/7add9",   "intervals": [0, 2, 3, 6, 10]},
	{ "name": "dim5/ 7th add 11th*",  "sym": "dim5/7add11",  "intervals": [0, 3, 5, 6, 10]},
	{ "name": "dim5/ 7th add 13th*",  "sym": "dim5/7add13",  "intervals": [0, 3, 6, 9, 10]},
	{ "name": "6th sus 4th add 9th",  "sym": "6sus4add9",    "intervals": [0, 2, 5, 7,  9]},
	{ "name": "7th sus 4th add 9th",  "sym": "7sus4add9",    "intervals": [0, 2, 5, 7, 10]},
	{ "name": "7th sus4 add 13th",    "sym": "7sus4add13",   "intervals": [0, 5, 7, 9, 10]},
	{ "name": "M7th sus4th add9th",   "sym": "M7sus4add9",   "intervals": [0, 2, 5, 7, 11]},
	{ "name": "M7th sus4th add13",    "sym": "M7sus4add13",  "intervals": [0, 5, 7, 9, 11]},
	{ "name": "7th sus2 add 13th",    "sym": "7sus2add13",   "intervals": [0, 2, 7, 9, 10]},
	{ "name": "M7th sus2nd add13",    "sym": "M7sus2add13",  "intervals": [0, 2, 7, 9, 11]}
]');

$scales = json_decode('[
    { "name": "Major"                ,  "intervals": [ 0, 2, 4, 5, 7, 9, 11]},
    { "name": "Minor (natural)"      ,  "intervals": [ 0, 2, 3, 5, 7, 8, 10]},
    { "name": "minor (harmonic)"     ,  "intervals": [ 0, 2, 3, 5, 7, 8, 11]},
    { "name": "minor (melodic)"      ,  "intervals": [ 0, 2, 3, 5, 7, 9, 11]},
    { "name": "Ionian (mC) / Major"  ,  "intervals": [ 0, 2, 4, 5, 7, 9, 11]},
    { "name": "Dorian (mD)"          ,  "intervals": [ 0, 2, 3, 5, 7, 9, 10]},
    { "name": "Phrygian (mE)"        ,  "intervals": [ 0, 1, 3, 5, 7, 8, 10]},
    { "name": "Lydian (mF)"          ,  "intervals": [ 0, 2, 4, 6, 7, 9, 11]},
    { "name": "Mixolydian (mG)"      ,  "intervals": [ 0, 2, 4, 5, 7, 9, 10]},
    { "name": "Aeolian (mA, minor)"  ,  "intervals": [ 0, 2, 3, 5, 7, 8, 10]},
    { "name": "Locrian (mB)"         ,  "intervals": [ 0, 1, 3, 5, 6, 8, 10]},
    { "name": "Pentatonic Major"     ,  "intervals": [ 0, 2, 4, 7, 9]},
    { "name": "Pentatonic minor"     ,  "intervals": [ 0, 3, 5, 7, 10]},
    { "name": "Spanish"              ,  "intervals": [ 0, 1, 4, 5, 7, 8, 10]},
    { "name": "Gypsy"                ,  "intervals": [ 0, 1, 4, 5, 7, 8, 11]},
    { "name": "Spanish 8 Tone"       ,  "intervals": [ 0, 1, 3, 4, 5, 6, 8, 10]},
    { "name": "Flamenco"             ,  "intervals": [ 0, 1, 3, 4, 5, 7, 8, 10]}
]');


$tunings = json_decode('[
	{ "val": ["E",  "B",  "G",  "D",  "A",  "E"  ], "name": "EADGBE (standard)" },
	{ "val": ["F",  "C",  "G",  "D",  "A",  "E"  ], "name": "EADGCF (4th)" },
	{ "val": ["B",  "A",  "E",  "D",  "G",  "C"  ], "name": "CGDAEB (5th)" },
	{ "val": ["G",  "E",  "A",  "D",  "G",  "C"  ], "name": "CGDAEG (NST)" },
	{ "val": ["E",  "B",  "G",  "D",  "A",  "D"  ], "name": "DADGBE (drop D)" },
	{ "val": ["E",  "B",  "G#", "E",  "B",  "E"  ], "name": "EBEG#BE (Open E)" },
	{ "val": ["D",  "B",  "G",  "D",  "G",  "D"  ], "name": "(D)GDGBD (Open G)" },
	{ "val": ["D",  "A",  "F",  "C",  "G",  "C"  ], "name": "CGCFAD (Drop C)" },
	{ "val": ["Eb", "Bb", "Gb", "Db", "Ab", "Eb" ], "name": "EbAbDbGbBbEb (Eb -1/2 step down)" },
	{ "val": ["D",  "A",  "F",  "D",  "G",  "D"  ], "name": "DGCFAD (full step down)" },
	{ "val": ["C",  "F",  "Eb", "B",  "F",  "C"  ], "name": "CFBbEbGC (C Standard)" },
	{ "val": ["B",  "E",  "A",  "D",  "F#", "B"  ], "name": "BEADF#B  (Baryton)" },
	{ "val": ["D",  "A",  "G",  "D",  "A",  "D"  ], "name": "DADGAD" },
	{ "val": ["D",  "A",  "F#", "D",  "A",  "D"  ], "name": "DADF#AD (DM/Vastopol)" },
	{ "val": ["D",  "A",  "F",  "D",  "A",  "D"  ], "name": "DADFAD (Dm)" },
	{ "val": ["D",  "B",  "G",  "D",  "G",  "D"  ], "name": "DGDGBD (GM)" },
	{ "val": ["D",  "Bb", "G",  "D",  "G",  "D"  ], "name": "DGDGBbD (Gm)" },
	{ "val": ["E",  "C",  "G",  "C",  "G",  "C"  ], "name": "CGCGCE (Open C)" },
	{ "val": [            "G",  "D",  "A",  "E"  ], "name": "Bass EADG (standard)" }
]');
?>
<table><tr><th>Visualisation</th><th>Note</th><th>Chord</th><th>Scale</th><th>Tuning</th></tr><tr>
<td>
<select id="viz" onchange="show()">
	<option value="show" selected>Afficher</option>
	<option value="mask" >Masquer</option>
</select>
<td>
<select id="root" onchange="show()">
<?php
$root = 3;
foreach ($notes as $i => $n) {
	if ($root == $i) {
		$sel="selected='selected'";
	} else {
		$sel="";
	}
	echo("<option value='$i' $sel>$n</option>\n");
}
?>
</select></td><td>
<select id="chord" onchange="chord_show()">
	<option value="none" selected>none</option>
<?php
#foreach ($chords as $c) {
foreach ($chorddict as $c) {
	#$val = json_encode([ $c->root, $c->third, $c->fifth, $c->added ]); 
	$val = json_encode($c->intervals); 
	#echo("<option value='$val'>$c->sym ($c->name)</option>\n");
	echo("<option value='$val'>$c->sym</option>\n");
}
?>
</select>
</td><td>
<select id="scale" onchange="scale_show()">
	<option value="none" selected>none</option>
<?php
foreach ($scales as $scl) {
	$val = json_encode($scl->intervals);
	echo("<option value='$val'>$scl->name</option>\n");
}
?>
</select>
</td><td>
<select id="tune" onchange="show()">
<?php
	foreach ($tunings as $t) {
		print("\t<option value='" .json_encode($t->val) ."'>$t->name</options>\n");
	}
?>
</select>
</td>
</tr></table>
<script>
notes  = [ "A", "A#/Bb", "B", "C", "C#/Db", "D", "D#/Eb", "E", "F", "F#/Gb", "G", "G#/Ab" ];

//var fb = new fretboard("<?php echo $div;?>", {"strnames" : ["D", "A", "D", "G", "A", "D"]});
var fb = new fretboard("<?php echo $div;?>");
fb.draw();
function viz_set() {
	e = document.getElementById("viz");
	viz = e.options[e.selectedIndex].value;
	console.log("viz str = " + viz);
	fb.viz_mode(viz);
}
function note_show() {
	e = document.getElementById("root");
	root = parseInt(e.options[e.selectedIndex].value);
	fb.note_show(notes[root]);
}
function chord_show() {
	scale_reset()
	r     = document.getElementById("root");
	root  = parseInt(r.options[r.selectedIndex].value);
	c     = document.getElementById("chord");
	if (c.options[c.selectedIndex].value == "none") {
		note_show();
	} else {
		chord = JSON.parse(c.options[c.selectedIndex].value);
		fb.chord_show(root, chord);	
	}
}
function scale_show() {
	chord_reset()
	r     = document.getElementById("root");
	root  = parseInt(r.options[r.selectedIndex].value);
	s     = document.getElementById("scale");
	if (s.options[s.selectedIndex].value == "none") {
		note_show();
	} else {
		scl = JSON.parse(s.options[s.selectedIndex].value);
		fb.chord_show(root, scl);	
	}
}
function chord_reset() {
	c = document.getElementById("chord");
	c.selectedIndex = 0;
}
function scale_reset() {
	s = document.getElementById("scale");
	s.selectedIndex = 0;
}
function tune_set() {
	t     = document.getElementById("tune");
	fb.tune(t.options[t.selectedIndex].value);
}
function show() {
	tune_set();
	viz_set();
	c     = document.getElementById("chord");
	if (c.options[c.selectedIndex].value != "none") {
		chord_show();
	} else {
		s = document.getElementById("scale");
		if (s.options[s.selectedIndex].value != "none") {
			scale_show();
		} else {
			note_show();
		}
	}
}
show();
</script>
<br/><br/><h2>Positions relatives</h2>
<?php
$div ="fboard2";
print("<br>\n");
print("<div id='$div'>\n");
print("</div>\n");
?>
<table><tr><th>Visualisation</th><th>Chord</th><th>Scale</th><th>Tuning</th></tr><tr>
<td>
<select id="relviz" onchange="rel_show()">
	<option value="show" selected>Afficher</option>
	<option value="mask" >Masquer</option>
</select>
</td>
<td>
<select id="relchord" onchange="rel_chord_show(); rel_show();">
	<option value="none" selected>none</option>
<?php
foreach ($chorddict as $c) {
	$val = json_encode($c->intervals); 
	echo("<option value='$val'>$c->sym</option>\n");
}
?>
</select>
</td>
<td>
<select id="relscale" onchange="rel_scale_show(); rel_show()";>
	<option value="none" selected>none</option>
<?php
foreach ($scales as $scl) {
	$val = json_encode($scl->intervals);
	echo("<option value='$val'>$scl->name</option>\n");
}
?>
</select>
</td>
<td>
<select id="reltune" onchange="rel_show()">
<?php
	foreach ($tunings as $t) {
		print("\t<option value='" .json_encode($t->val) ."'>$t->name</options>\n");
	}
?>
</select>
</td>
</tr></table>
<br/><br/>
<script>
var div2  = "<?php echo $div;?>";
var fb2   = new fretboard(div2, {nfrets: 11, relative: true, numbers: false, marks: false, onclick: 'rel_root_set(this.id)'});
var idx   = false;
var chord = null;
fb2.draw();
function rel_root_set(id) {
	idx = id;
	rel_show();
}
function rel_tune_set() {
	t     = document.getElementById("reltune");
	fb2.tune(t.options[t.selectedIndex].value);
}
function rel_viz_set() {
	var e = document.getElementById("relviz");
	var viz = e.options[e.selectedIndex].value;
	fb2.viz_mode(viz);
}
function rel_chord_show() {
	rel_scale_reset()
	s     = document.getElementById("relchord");
	chord = s.options[s.selectedIndex].value;
	if (chord == "none") chord = null;
	else chord = JSON.parse(chord);
}
function rel_scale_show() {
	s     = document.getElementById("relscale");
	rel_chord_reset()
	chord = s.options[s.selectedIndex].value;
	if (chord == "none") chord = null;
	else chord = JSON.parse(chord);
}
function rel_chord_reset() {
	c = document.getElementById("relchord");
	c.selectedIndex = 0;
}
function rel_scale_reset() {
	s = document.getElementById("relscale");
	s.selectedIndex = 0;
}
function rel_show() {
	rel_viz_set();
	rel_tune_set();
	c     = document.getElementById("relchord");
	if (c.options[c.selectedIndex].value != "none") {
		chord = JSON.parse(c.options[c.selectedIndex].value)
	} else {
		s = document.getElementById("relscale");
		if (s.options[s.selectedIndex].value != "none") {
			chord = JSON.parse(s.options[s.selectedIndex].value);
			rel_scale_show();
		}  
	}
console.log("chord = " + chord);
	fb2.relative_show(idx, chord);	
}
rel_show();
</script>

