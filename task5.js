function longestCommonPrefix(arrLines) {

    let shortestLine = arrLines[0];
    for (let i = 1; i < arrLines.length; i++) {
        if (arrLines[i].length < shortestLine.length) {
            shortestLine = arrLines[i];
        }
    }
    
    let longestPrefix = "";
    
    for (let i = 2; i <= shortestLine.length; i++) {
        for (let j = 0; j <= shortestLine.length - i; j++) {
            const currentSubstring = shortestLine.substring(j, j + i);
            let isCommon = true;
            
            for (const line of arrLines) {
                if (!line.includes(currentSubstring)) {
                    isCommon = false;
                    break;
                }
            }
            
            if (isCommon && currentSubstring.length > longestPrefix.length) {
                longestPrefix = currentSubstring;
            }
        }
    }
    
    return longestPrefix;
}

console.log("Ввод: ['цветок','поток','хлопок']");
console.log("Вывод:", longestCommonPrefix(['цветок','поток','хлопок']));
console.log("Ожидаемый вывод: 'ок'\n");

console.log("Ввод: ['собака','гоночная машина','машина']");
console.log("Вывод:", longestCommonPrefix(['собака','гоночная машина','машина']));
console.log("Ожидаемый вывод: ''");