/* eslint-env node */
module.exports = {
  root: true,
  parser: 'vue-eslint-parser',
  parserOptions: {
    parser: '@typescript-eslint/parser',
  },
  extends: [
    'plugin:vue/vue3-essential',
    'eslint:recommended',
    'plugin:vue/strongly-recommended',
    '@vue/typescript/recommended',
    'prettier',
  ],
  rules: {
    indent: ['error', 2],
    'max-len': ['error', { code: 120, }],
    // quotes: ['error', 'single'],
    'vue/no-multiple-template-root': 'off',
    'vue/script-setup-uses-vars': 'off'
  },
  plugins: ['@typescript-eslint', 'prettier'],
};
