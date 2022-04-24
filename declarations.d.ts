interface PasswordGenerationConfig {
  memorable: boolean;
  length?: number;
  specialCharacters: boolean;
  maj: boolean;
  numbers: boolean;
}

interface GeneratedPassword {
  plainPassword: string;
  usedWithConfig: PasswordGenerationConfig;
  words?: string[];
}

interface DuplicatedInfo {
  duplicatedChars: string[];
  iterations: number[];
  score: number;
}

interface GenerationConfig {
  onGeneration?: (password: GeneratedPassword) => void;
  onCopy?: (copiedText: string) => void;
}

declare var Swal: any;
