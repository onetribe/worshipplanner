<template>
    <div :class="classObject" v-html="lyricsFormatted">
    </div>
</template>

<script>
    export default {
        props: {
            'song': {
              'type': Object
            },
            'showingChords': {
              'type': Boolean,
              'default': true
            },
            'showingSections': {
              'type': Boolean,
              'default': true
            },
            'showingComments': {
              'type': Boolean,
              'default': true
            },
            'showingColumns': {
              'type': Boolean,
              'default': false
            }
        },
        computed: {
            lyrics: function () {
                if (this.song.lyrics) {
                    return this.song.lyrics;
                }

                return this.song.song_lyrics 
                    ? this.song.song_lyrics 
                    : (this.song.song ? this.song.song.lyrics : "");
            },
            classObject: function () {
                return {
                  'wp-2-columns': this.showingColumns
                }
            },
            lyricsFormatted: function () {
                var lines = this.lyrics.split("\n");
                var linesOut = [];

                for (var i = 0; i < lines.length; i++) {
                    var line = lines[i];
                    var className = "lyricLine";
                    var hideLine = false;

                    if (line[0] == ".") {
                        className = "chordLine";
                        if (this.showingChords) {
                            line = line.substring(1, line.length);
                            line = line.replace(/ /g, '\u00a0');
                            line = line.replace(/\t/g, '\u00a0\u00a0\u00a0\u00a0');
                            //indent line
                            line = this.showingColumns ? line : "\u00a0\u00a0\u00a0\u00a0" + line;
                        } else {
                            hideLine = true;
                        }
                        
                    } else if (line[0] == ";") {
                        className = "commentLine";
                        if (this.showingComments) {
                            line = line.substring(1,line.length);
                        } else {
                            hideLine = true;
                        }
                    } else if (line[0] == "[") {
                        className = "sectionLine";
                        if (!this.showingSections) {
                            hideLine = true;
                        }
                    } else if (line[0] == " ") {
                        line = line.substring(1,line.length);
                        //indent line
                        line = this.showingColumns ? line : "\u00a0\u00a0\u00a0\u00a0" + line;
                    }

                    if (!hideLine) {
                        linesOut.push("<span class='" + className + "'>" + line + "</span><br/>");    
                    }
                }

                return linesOut.join("\n");
            }
        },
        mounted() {
        }
    }
</script>
