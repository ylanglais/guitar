console.log("fretboard loaded");
var fretboard = class {
	constructor(div, params) {
		this.div         = div;
		this.current_rel = null;	
		var c = new options({"nfrets":   {"type": "number",  "val": 20, "min": 4, "max": 20}, 
					 	     "header":   {"type": "boolean", "val": true }, 
							 "relative": {"type": "boolean", "val": false },
							 "mask":     {"type": "boolean", "val": false },
					         "numbers":  {"type": "boolean", "val": true }, 
					         "marks":    {"type": "boolean", "val": true },
							 "stdbg":    {"type": "string",  "val": "white" },
							 "stdfg":    {"type": "string",  "val": "black" },
							 "rootfg":   {"type": "string",  "val": "#FF0000" },
						     "mskbg":    {"type": "string",  "val": "#AAAAAA" },
							 "onclick":  {"type": "string",  "val": null },
							 //"nstrings": {"type": "number",  "val": 6, "min": 4, "max": 12 },
							 "bgcolors": {"type": "object",  "val": [ "#FF0000", "#FFFF00", "#0000FF", "#00FF00", "#FF00FF", "#00FFFF", "Orange",  "BlueViolet", "SpringGreen", "Gold"]},
							 "fgcolors": {"type": "object",  "val": [ "#FFFFFF", "#000000", "#FFFFFF", "#000000", "#FFFFFF", "#000000", "#FFFFFF", "#FFFFFF", "#000000", "#FFFFFF"]},
							 "markchar": {"type": "string",  "val": "●"},
							 "strnames": {"type": "object",  "val": ['E', "B", "G", "D", "A", "E" ]}
						    });

		this.conf      	 = c.parse(params);
		console.log(this.conf);
		this.sel       = [ false, false, false, false, false, false ];

				  	  //    0    1        2    3    4       5    6        7    8     9        10    11
		this.nrefb     = [ "A", "Bb",    "B", "C", "Db",    "D", "Eb",    "E", "F",  "Gb",    "G",  "Ab"    ];
		this.nrefd     = [ "A", "A#",    "B", "C", "C#",    "D", "D#",    "E", "F",  "F#",    "G",  "G#"    ];
		this.notes     = [ "A", "A#/Bb", "B", "C", "C#/Db", "D", "D#/Eb", "E", "F",  "F#/Gb", "G",  "G#/Ab" ];
		this.intervals = [ "1", "2m",    "2", "3m", "3",    "4", "5m",    "5", "6m", "6",     "7m", "7"     ];
		this.strings_  = [ 7,   2,   10,   5,   0,   7 ];
		this.stdbg     = "white";
		this.marks     = { '3': 1, '5': 1, '7': 1, '9': 1, '12': 2, '15': 1, '17': 1, '19': 1 };

		this.fretnum   = "<td colspan='3' class='fretnum'>\$frtn</td>";
		this.fretmks   = "<td colspan='3' class='fretmarks'>\$mark</td>";
		this.frettop   = "<td class='fb l msk' id='\$id_tl'></td><td class='fb msk' rowspan='2' id='\$id' \$func>\$note</td><td class='fb r msk' id='\$id_tr'></td>";
		this.fretbot   = "<td class='fb l b msk' id='\$id_bl'></td><td class='fb r b msk' id='\$id_br'></td>";
		this.frethdr   = "<th rowspan='2' class='fb msk' id='\$id'>\$note</th>";
		this.style     = "\
table.fb { border: 0px solid black; border-spacing: 0px; padding: 0px}\
tr.fb    { border: 0px solid black }\
th.fb  { \
	border: 	  0px solid black;\
	border-right: 2px double black;\
	width: 20px;\
}\
td.fb.msk {\
	color: white;\
	background-color: white;\
}\
td.fb.sel { color: white; background-color: red; }\
td.fretnum, td.fretmarks {\
	text-align: center;\
	border: 0px solid black; \
}\
td.fb { \
	border: 0px solid black; \
	width: 20px;\
	height: 1.0em;\
	text-align: center;\
	vertical-align: middle;\
}\
td.l {\
	border: 0px solid black; \
	border-left:   1px solid black;\
	border-right:  0px solid black;\
	border-bottom: 1px solid black;\
	width: 20px;\
}\
td.r {\
	border:        0px solid black; \
	border-left:   0px solid black;\
	border-right:  1px solid black;\
	border-bottom: 1px solid black;\
	width: 20px;\
}\
td.b{\
	border-bottom: 0px solid black;\
}\
";
		this.tune(this.conf.strnames);
	}
	tune(strings) {
		var need_redraw = false;
		this.strings   = [];

		if (typeof strings === "string") 
			strings = JSON.parse(strings);

		//console.log("input tuning: " + strings);

		if (strings.length != this.conf.strnames.length) 
			need_redraw = true;


		this.conf.strnames = strings;
		for (let sn of this.conf.strnames) {
			var i = this.notes.indexOf(sn);
			if (i < 0) i = this.nrefb.indexOf(sn);
			if (i < 0) i = this.nrefd.indexOf(sn);

//			console.log("note: " + sn + " index = " + i);

			if (i < 0) { 
				console.log("ERROR: Unknown note " + sn + ", reset to standard tuning");
				this.tune(['E', "B", "G", "D", "A", "E" ]);
				return;
			} else {
				this.strings.push(i);
			}
		}
		//console.log("this.strings: " + this.strings);
		if (need_redraw) this.draw();
	}
	
	current_relative() {
		return this.current_rel;
	}

	viz_mode(mask) {
		if (mask == "mask") {
			this.conf.mask = true;
		} else {
			this.conf.mask = false;
		}
		//console.log("viz mode: " + mask);
	}

	draw() {
		var str = "<style>" + this.style + "</style>"; 
		str += "<table class='fb'>";

		//console.log("in draw");

		// Fret numbers:
		if (this.conf.numbers) {
			str += "<tr class='fb'><th></th>";
			for (var fret = 1; fret < this.conf.nfrets; fret++) {
				str += this.fretnum.replace(/\$frtn/g, fret);
			}
			str += "</tr>\n";
		}

		// fretborad:
		for (let s in this.strings) {
			str += "<tr class='b'>";
			var b = this.notes.indexOf(this.conf.strnames[s]);
			if (b < 0) b = this.nrefb.indexOf(this.conf.strnames[s]);
			if (b < 0) b = this.nrefd.indexOf(this.conf.strnames[s]);


			//var b = this.notes.indexOf(this.conf.strnames[s]);

			// Header (string names):
			if (this.conf.header) {
				var t = "";
				if (this.conf.selectable != false) t = "onclick='" + this.div + ".select(" + s + ", " + fret +")'";
				str += this.frethdr.replace(/\$id/g,  this.div + "_" + s + "_0").replace(/\$note/g, this.conf.strnames[s]);
			}
			// strings (top part):
			for (var fret = 1; fret < this.conf.nfrets; fret++) {
				var t = "";
				if (this.conf.onclick != null) t = "onclick='" + this.conf.onclick + "'"; 
				else if (this.conf.selectable != false) t = "onclick='" + this.div + ".select(" + s + ", " + fret +")'"; 
				var fbn = (b + fret) % 12;
				//console.log("open: " + b + ", fret: " + fret + ", fbn = "+ fbn + ", note = " + this.notes[fbn]);
				str += this.frettop.replace(/\$id/g, this.div + "_" + s + "_" + fret).replace(/\$note/g, this.notes[fbn]).replace(/\$func/g, t);
			}

			// strings (bottom part):
			str += "</tr>\n<tr class='b'>";
			for (var fret = 1; fret < this.conf.nfrets; fret++) {
				str += this.fretbot.replace(/\$id/g, this.div + "_" + s + "_" + fret);
			}
			str += "</tr>\n";
		}

		// Fret marks:
		if (this.conf.marks) {
			str += "<tr class='b'><th></th>\n";
			for (var fret = 1; fret < this.conf.nfrets; fret++) {
				var ms = this.fretmks;
				var m  = "";
				if ((""+fret) in this.marks) {
					m = this.conf.markchar
					if (this.marks[fret] == 2) {
						m += this.conf.markchar;
					}
				} 
				str += ms.replace(/\$mark/g, m);
			}
		}
		str += "</table>\n";

		document.getElementById(this.div).innerHTML = str;
	}		

	relative_show(id, chord) {
		this.reset();
		if (!id) {
			var f;
			if (this.conf.nfrets % 2 == 1) f = (this.conf.nfrets - 1) / 2;
			else f = this.conf.nfrets / 2;
			id = this.id + "_" + (this.conf.strnames.length - 1) + "_" + f;
		}
		this.current_rel   = id;

		if (chord != null) this.reset();
		var found = id.match("^.*_([^_]*)_([^_]*)$");
		var rfret = found[2];
		var rstrg = found[1];
		var ints  = [];
		ints[0] = 0;


		/* compute intervals between strings: */
		for (var i = 1; i < this.conf.strnames.length; i++) {
			ints[i] = (this.strings[i] - this.strings[i-1]) % 12;
			if (ints[i] < 0) ints[i] += 12;
		}

		/* compute interval of 1st fret of picked string: */
		var intcs = (0 - rfret);
		while (intcs < 0) intcs += 12;

		/* compute interval of 1st fret of 1st string: */
		for (var i = rstrg; i >= 0; i--) {
			intcs -= ints[i];
			while (intcs < 0) intcs += 12;
		}

		/* for each strings: */
		var intc = intcs;
		for (i = 0; i < this.conf.strnames.length; i++) {
			intcs += ints[i];
			intc = intcs;
			for (var f = 1; f < this.conf.nfrets; f++) {
				var e = document.getElementById(this.div + "_" + i + "_" + f);
				var iv = (intc + f ) % 12;
				e.innerHTML = this.intervals[iv];
				if (e.innerHTML == '1') {
					e.innerHTML   = 'R';
					e.style.color      = this.conf.rootfg;
					e.style.background = this.conf.stdbg;
				} else {
					e.style.color = this.conf.stdfg;
				}
				if (chord != null && chord.lastIndexOf(iv) >= 0) {
					if (this.conf.mask) {
						e.style.background = this.conf.stdbg; 	
					} else {
						var ix = chord.lastIndexOf(iv)
						e.style.background = this.conf.bgcolors[ix];
						e.style.color      = this.conf.fgcolors[ix];
					}
				}	
			}
		}	
	}

	select(string, fret) {
		if (this.sel[string] !== false) {
			e = document.getElementById(this.div + "_" + string + "_" + this.sel[string]);
			e.classList.remove("root");
			e.classList.remove("sel");
			e.classList.add("msk");
			if (fret == this.sel[string]) {
				this.sel[string] = false;
				return;
			}
		}
		e = document.getElementById(this.div + "_" + string + "_" + fret);
		e.classList.add("sel");
		e.classList.remove("msk");
		if (fret == this.sel[string]) this.sel[string] = false;
		this.sel[string] = fret;
	}	

	note_show(note) {
		this.reset();
		for (var i = 0; i < this.conf.strnames.length; i++) {
			var b = this.strings[i];
			for (var f = 1; f < this.conf.nfrets; f++) {
				var fbn = (b + f) % 12;
				if (this.notes[fbn] == note) {
					var e = document.getElementById(this.div + "_" + i + "_" + f);
					if (!e) {
						console.log("no " + (this.div + "_" + i + "_" + f) + " element");
						continue;
					}
					e.saved      	   = e.innerHTML;
					e.innerHTML 	   = this.notes[fbn];
					if (this.conf.mask) {
						e.style.background = this.conf.stdbg;
						e.style.color      = this.conf.rootfg;
					} else {
						e.style.background = this.conf.bgcolors[0];
						e.style.color      = this.conf.fgcolors[0];
					}
				}
			}
		}
	}
	reset() {
		//if (this.conf.selectable == true) return;
		for (var i = 0; i < this.conf.strnames.length; i++) {
			var b = this.strings[i];
			for (var f = 0; f < this.conf.nfrets; f++) {
				var e = document.getElementById(this.div + "_" + i + "_" + f);
				if (!e) {
					console.log("no " + (this.div + "_" + i + "_" + f) + " element");
					continue;
				}
				if (f == 0) 
					e.innerHTML = this.conf.strnames[i];
				else 
					e.innerHTML = "";

				if (this.conf.mask && e.classList.contains("msk")) {
					e.style.background = this.conf.mskbg;
					if (f > 0) {
						document.getElementById(this.div + "_" + i + "_" + f + "_tl").style.background = this.conf.mskbg;
						document.getElementById(this.div + "_" + i + "_" + f + "_tr").style.background = this.conf.mskbg;
						document.getElementById(this.div + "_" + i + "_" + f + "_bl").style.background = this.conf.mskbg;
						document.getElementById(this.div + "_" + i + "_" + f + "_br").style.background = this.conf.mskbg;
					} 
					
				} else {
					if (f > 0) {
						document.getElementById(this.div + "_" + i + "_" + f + "_tl").style.background = this.conf.stdbg;
						document.getElementById(this.div + "_" + i + "_" + f + "_tr").style.background = this.conf.stdbg;
						document.getElementById(this.div + "_" + i + "_" + f + "_bl").style.background = this.conf.stdbg;
						document.getElementById(this.div + "_" + i + "_" + f + "_br").style.background = this.conf.stdbg;
					}
					e.style.background = this.conf.stdbg;
				}
				e.style.color          = this.conf.stdfg;
			}
		}
	}
	chord_show(note, chord) {
		this.reset();
		// Loop on strings:
		for (var i = 0; i < this.conf.strnames.length; i++) {
			// get base note from string:
			var b = this.strings[i];

			for (var f = 0; f < this.conf.nfrets; f++) {
				var fbn = (b + f) % 12;
				var c = 0;
				for (let nte of chord) {
					var n = this.notes[(note + nte) % 12];
					// console.log("b = " + b + ", (i, f) = (" +i +', ' + f + ") nte = " + nte + ", root: " + note + ", n = " + n);
					if (this.notes[fbn] == n) {
						var e = document.getElementById(this.div + "_" + i + "_" + f);
						e.saved            = e.innerHTML;
						e.innerHTML        = this.notes[fbn];
						// console.log("note = " + note + ", n = " + n +  ", c = " + c);
						if (this.conf.mask) {
							e.style.background = this.conf.stdbg;
							if (fbn == note) 
								e.style.color      = this.conf.rootfg;
							else 
								e.style.color      = this.conf.stdfg;
						} else {
							e.style.background = this.conf.bgcolors[c];
							e.style.color      = this.conf.fgcolors[c];
						}
						break;
					}
					c++;	
				}
			}
		}
	}
}
