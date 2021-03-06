class LyricLineDetect {

  constructor() {
    this.availableChords = ["A","Ab","A#","Bb","B","C","C#","Db","D","D#","Eb","E","F","F#","Gb","G","G#","A♭","B♭","D♭","E♭","G♭","A♯","C♯","D♯","F♯","G♯","H","Hb","H♭"];
  }

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
    var tokens = line.replace(/\(|\)|\//g, " ").replace(/[0-9]/g, "").replace(/sus|maj|dim|aug|m|\.|\+|/g,"").toUpperCase().replace(/\s+/g," ").trim().split(" ");
    var countMatches = 0;
    var countWords = 0;

    for (var i = 0; i < tokens.length; i++) {
        if (tokens[i].length > 2) {
            countWords++;
        }
        if (this.availableChords.indexOf(tokens[i]) != -1) countMatches++;
    }

    if ((countMatches / tokens.length) >= 0.5 && countWords == 0) 
        return true;
    else 
        return false;
  }

  isSectionLine(line) {
    if(line.indexOf("[") != -1 && line.indexOf("]") != -1 && line.trim().substring(0,1) == "[" ) {
        return true;
    }

    var sectionWords = ["chorus", "verse", "pre-chorus","bridge","v1","v2","v3","v4","v5","v6", "intro"];
    var found = false;
    sectionWords.forEach(function (word) {
        if (line.toUpperCase().indexOf(word.toUpperCase()) != -1) {
            found = true;
            return;
        }
    });

    //also ignore as section if the line length is fairly long
    //verse and bridge could be part of other words like "universe"
    //in that case the line length is likely longer than 15 characters
    if (found && line.length <= 15) return true;

    return false;
  }

  isCommentLine(line) {
    if(line.trim().substring(0,1) == ";" )
        return true

    return false;
  }

  convertText(lyrics, replaceSharpsAndFlats = false) {
    var lineTypes = this.detect(lyrics);
    var lines = lyrics.split("\n");

    for (var i = 0; i < lineTypes.length; i++) {
        if (lineTypes[i] == "chord" && lines[i].trim().substring(0, 1) != ".") {
            lines[i] = "." + lines[i];
        } else if (lineTypes[i] == "section" && lines[i].trim().substring(0, 1) != "[") {
            lines[i] = "[" + lines[i].replace(/\s+/g, "") + "]".trim();
        } else if (lineTypes[i] == "comment"){
            lines[i] = lines[i].trim();
        } else if (lineTypes[i] == "lyric"){
            lines[i] = (lines[i].trim().length > 0 ? " " : "") + (lines[i].trim());
        }
    }

    lyrics = lines.join("\n");

    if (replaceSharpsAndFlats) {
        lyrics = this.replaceSharpsAndFlats(lyrics);
    }

    return lyrics;
  }


  replaceSharpsAndFlats(lyrics) {
    var lineTypes = this.detect(lyrics);
    var lines = lyrics.split("\n");

    for (var i = 0; i < lineTypes.length; i++) {
        if (lineTypes[i] == "chord") {
            lines[i] = lines[i].replace(/b/g, "♭").replace(/#/g, "♯");
        }
    }

    return lines.join("\n");
  }

};

export { LyricLineDetect };