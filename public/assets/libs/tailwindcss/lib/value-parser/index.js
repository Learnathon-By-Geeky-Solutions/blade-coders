"use strict";
var parse = require("./parse.js");
var walk = require("./walk.js");
var stringify = require("./stringify.js");
function ValueParser(value) {
    if (this instanceof ValueParser) {
        this.nodes = parse(value);
        return this;
    }
    return new ValueParser(value);
}
ValueParser.prototype.toString = function() {
    return Array.isArray(this.nodes) ? stringify(this.nodes) : "";
};
ValueParser.prototype.walk = function(cb, bubble) {
    walk(this.nodes, cb, bubble);
    return this;
};
ValueParser.unit = require("./unit.js");
ValueParser.walk = walk;
ValueParser.stringify = stringify;
module.exports = ValueParser;
