module.exports = {
  trailingComma: 'es5',
  singleQuote: true,
  overrides: [
    {
      files: '*.scss',
      options: {
        singleQuote: false,
      },
    },
  ],
};
