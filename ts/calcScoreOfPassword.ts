const minAlpha = "abcdefghijklmnopqrstuvwxyz";
const majAlpha = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
const numbersAlpha = "0123456789";
const specialCharactersAlpha = "&'(§!)-_$*%+=/:.;?,@#<>";

function frame(min: number, n: number, max: number, strict: boolean = true): boolean {
  if (strict) {
    return min < n && max > n;
  } else {
    return min <= n && max >= n;
  }
}

/**
 * Calculates a score based on the duplicated letters and the number of duplicated letters present in a string.
 * This score is the sum of the different letters that are found multiple times and how many times they're counted.
 * @param str The string in which to search for duplicated letters and the number of duplications.
 * @returns The information about the duplications.
 */
function calcDuplicates(str: string): DuplicatedInfo {
  let score = 0;
  const duplicatedChars = [];
  const iterations = [];
  for (let i = 0; i < str.length; i++) {
    const char = str[i];
    const indexInDuplicate = duplicatedChars.findIndex((v) => v === char);
    if (indexInDuplicate >= 0) {
      iterations[indexInDuplicate] += 1;
    } else {
      // If the char is already in the beginning of the string.
      if (str.substring(0, i).indexOf(char) !== -1) {
        duplicatedChars.push(char);
        iterations.push(2);
      }
    }
  }
  for (let i = 0; i < duplicatedChars.length; i++) {
    score += iterations[i];
  }
  return {
    score,
    iterations,
    duplicatedChars,
  };
}

/**
 * Finds negative known patterns for password such as dates.
 * It should check for names and public places but it'd be too hard to handle.
 * @param str The password.
 * @returns A score based on the negative password. A high score means a bad password.
 */
function findNegativePatterns(str: string): number {
  let score = 0;
  const negativePatterns = [
    /\d{8}/g,
    /\d{1,2}-\d{1,2}-(?:\d{4}|\d{2})(?:\b|\w+)/g,
    /(?:\d{4}|\d{2})-\d{1,2}-\d{1,2}(?:\b|\w+)/g,
  ];
  for (let pattern of negativePatterns) {
    if (pattern.test(str)) {
      score++;
    }
  }
  return score;
}

/**
 * Calculates the score of a password to determine whether it's secure or not,
 * according to the following model, with N the number of possible characters and L the length of the password.
 *  L = 8  ; N = 70	Extremly weak, 0 or 1 out of 10.
 *  L = 10 ; N = 90	Very weak, 2 or 3 out of 10.
 *  L = 12 ; N = 90	Weak, 4 or 5 out of 10.
 *  L = 16 ; N = 36	Medium, 6 or 7 out of 10.
 *  L = 16 ; N = 90	Strong, 8 or 9 out of 10.
 *  L = 20 ; N = 90	Very strong, 10 out of 10.
 * @param result The score, from 0 to 10 out of 10.
 * @returns The score of a password.
 */
function calcScoreOf(result: GeneratedPassword): number {
  const L = result.plainPassword.length;
  const duplicationInfo = calcDuplicates(result.plainPassword);
  const dupliScore = duplicationInfo.score;
  const negativeScore = findNegativePatterns(result.plainPassword);
  let N = minAlpha.length;
  if (result.usedWithConfig.maj) N += majAlpha.length;
  if (result.usedWithConfig.numbers) N += numbersAlpha.length;
  if (result.usedWithConfig.specialCharacters) N += specialCharactersAlpha.length;
  const strength = N ** (L - duplicationInfo.duplicatedChars.length - negativeScore);
  if (frame(1 ** 1, strength, 70 ** 8, false)) return L > 6 && dupliScore < 2 ? 1 : 0;
  if (frame(70 ** 8 + 1, strength, 90 ** 11, false)) return L > 10 && dupliScore < 3 ? 3 : 2;
  if (frame(90 ** 11 + 1, strength, 36 ** 15, false)) return L > 13 && dupliScore < 10 ? 5 : 4;
  if (frame(36 ** 15 + 1, strength, 90 ** 15, false)) return L >= 15 && dupliScore < 20 ? 7 : 6;
  if (frame(90 ** 15 + 1, strength, 90 ** 19, false)) return L >= 16 && dupliScore < 30 ? 9 : 8;
  return 10;
}

/**
 * Guesses what's been the configuration used during the generation of the password.
 * We cannot know for sure whether 'memorable' was on or off because it may be only lower case letters.
 * We're supposing that if the password is not composed of any character from the other alphabets, then it's memorable.
 * @param plainPassword The password.
 * @returns The potential configuration during the generation of the password.
 */
function guessConfigFromPlainPassword(plainPassword: string): GeneratedPassword {
  const alphas = [majAlpha, numbersAlpha, specialCharactersAlpha];
  const didUse = [false, false, false];
  for (let i = 0; i < alphas.length; i++) {
    for (let char of alphas[i]) {
      if (plainPassword.includes(char)) {
        didUse[i] = true;
        break;
      }
    }
  }
  const isMemorable = didUse.filter((v) => v === true).length === 0;
  return {
    plainPassword,
    usedWithConfig: {
      memorable: isMemorable,
      maj: didUse[0],
      numbers: didUse[1],
      specialCharacters: didUse[2],
    },
    words: [], // we cannot guess
  };
}
