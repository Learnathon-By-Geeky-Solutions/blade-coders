"use strict";
Object.defineProperty(exports, "__esModule", {
    value: true
});
Object.defineProperty(exports, "backgroundSize", {
    enumerable: true,
    get: function() {
        return backgroundSize;
    }
});
const _dataTypes = require("./dataTypes.js");
const _splitAtTopLevelOnly = require("./splitAtTopLevelOnly.js");
function backgroundSize(value) {
    let keywordValues = [
        "cover",
        "contain"
    ];
    // the <length-percentage> type will probably be a css function
    // so we have to use `splitAtTopLevelOnly`
    return (0, _splitAtTopLevelOnly.splitAtTopLevelOnly)(value, ",").every((part)=>{
        let sizes = (0, _splitAtTopLevelOnly.splitAtTopLevelOnly)(part, "_").filter(Boolean);
        if (sizes.length === 1 && keywordValues.includes(sizes[0])) return true;
        if (sizes.length !== 1 && sizes.length !== 2) return false;
        return sizes.every((size)=>(0, _dataTypes.length)(size) || (0, _dataTypes.percentage)(size) || size === "auto");
    });
}
