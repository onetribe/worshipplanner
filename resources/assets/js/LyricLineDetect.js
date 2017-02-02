class LyricLineDetect {
  
  detect(lyrics) {
    var lines = lyrics.split("\n");
    var lineTypes = [];

    for (var i = 0; i < lines.length; i++) {
        if (this.isChordLine(lines[i])) lineTypes[i] = "chord";
        else if (this.isSectionLine(lines[i])) lineTypes[i] = "section";
        else if (this.isCommentLine(lines[i])) lineTypes[i] = "comment";
        else lineTypes[i] = "lyric";
    }
    
    return lineTypes;
  }

  isChordLine(line) {
    //exclude A, as that's a word
    var availableChords = ["A","Ab","A#","Bb","B","C","C#","Db","D","D#","Eb","E","F","F#","Gb","G","G#"];
    var tokens = line.replace(/[0-9]/g, "").replace(/m|sus|maj|dim|aug|sus7|\.|/g,"").toUpperCase().replace(/\(|\)|\//g, " ").replace(/\s+/g," ").trim().split(" ");
    var countMatches = 0;
    var countWords = 0;

    for (var i = 0; i < tokens.length; i++) {
        if (tokens[i].length > 2) {
            countWords++;
        }
        if (availableChords.indexOf(tokens[i]) != -1) countMatches++;
    }

    if ((countMatches / tokens.length) >= 0.5 && countWords == 0) 
        return true;
    else 
        return false;
  }

  isSectionLine(line) {
    if(line.indexOf("[") != -1 && line.indexOf("]") != -1 && line.trim().substring(0,1) == "[" )
        return true

    var sectionWords = ["chorus", "verse", "pre-chorus","bridge","v1","v2","v3","v4","v5","v6"];
    var found = false;
    sectionWords.forEach(function (word) {
        if (line.toUpperCase().indexOf(word.toUpperCase()) != -1) {
            found = true;
            return;
        }
    });

    if (found) return true;

    return false;
  }

  isCommentLine(line) {
    if(line.trim().substring(0,1) == ";" )
        return true

    return false;
  }

  convertText(lyrics) {
    var lineTypes = this.detect(lyrics);
    var lines = lyrics.split("\n");

    for (var i = 0; i < lineTypes.length; i++) {
        if (lineTypes[i] == "chord" && lines[i].trim().substring(0, 1) != ".") {
            lines[i] = "." + lines[i].trim();
        } else if (lineTypes[i] == "section" && lines[i].trim().substring(0, 1) != "[") {
            lines[i] = "[" + lines[i].replace(/\s+/g, "") + "]".trim();
        } else if (lineTypes[i] == "comment"){
            lines[i] = lines[i].trim();
        } else if (lineTypes[i] == "lyric"){
            lines[i] = (lines[i].trim().length > 0 ? " " : "") + (lines[i].trim());
        }
    }

    return lines.join("\n");
  }

};

export { LyricLineDetect };