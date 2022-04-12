
var options = class {
	constructor(spec) {
		if (typeof spec === "undefined") 
			this.spec = {};
		else 
			this.spec = spec;
		//console.log(this.spec);
	}
	add(option, type, val, min, max) {
		this.spec[option] = {};
		this.spec[option].type = type;

		if (typeof val !== 'undefined') this.spec[option].val = val;
		if (typeof min !== 'undefined') this.spec[option].min = min;
		if (typeof max !== 'undefined') this.spec[option].max = max;

		/*
		 * if (typeof nullable === 'undefined')    this.spec[option].nullable = true;
		 * else if (typeof nullable === 'boolean') this.spec[option].nullable = nullable;
		 * else                                    this.spec[option].nullable = true;
		 */
	}
	parse(params) {
		var out = {};
		var opts;
		if (typeof params === 'undefined')
			opts = {};	
		else if (typeof params === 'string') 
			opts = JSON.parse(params);
		else 
			opts = params;	


		for (var opt in this.spec) {
			var ok = true;
			if (opts.hasOwnProperty(opt)) {
				if (typeof opts[opt] === this.spec[opt].type) {
					if (this.spec[opt].min  !== 'undefined' && opts[opt] < this.spec[opt].min) {
						console.log("parameter ignored: " + opt + " (" +  opts[opt] + ") should be >= " + typeof opts[opt]);
						ok = false;	
					} 
					if (this.spec[opt].max  !== 'undefined' && opts[opt] > this.spec[opt].max) {
						console.log("parameter ignored: " + opt + " (" +  opts[opt] + ") should be <= " + typeof opts[opt]);
						ok = false;	
					}
					if (ok) out[opt] = opts[opt];
				} else {
					console.log("parameter ignored: " + opt + " property is a " + typeof opts[opt] + " shoud be of type " +  this.spec[opt].type);
					ok = false;
				}
			} else {
				ok = false;
			} 
		
			if (!ok && this.spec[opt].val !== 'undefined') {
				out[opt] = this.spec[opt].val;
			} 
		}
		return out;
	}
}
