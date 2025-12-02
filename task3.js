function spinWords(line) {

    const splittedLine = line.split(" ");
    const result = [];

    for (let i = 0; i < splittedLine.length; i++) {
        let word = splittedLine[i];

        if (word.length >= 5) {
            let reversed = "";
            for (let j = word.length - 1; j >= 0; j--) {
                reversed += word[j];
            }

            result.push(reversed)
        } else {
            result.push(word);
        }
    }

    line = result.join(" ")
    return line;
}

const result1 = spinWords( "Привет от Legacy" )
console.log(result1) // тевирП от ycageL

const result2 = spinWords( "This is a test" )
console.log(result2) // This is a test