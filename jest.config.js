module.exports = {
    testEnvironment: 'jsdom', // Use Node.js environment for testing
    roots: ['<rootDir>/test'], // Define the root directory for tests
    setupFiles: ['<rootDir>/jest.setup.js'],
    testMatch: ['**/*.test.js'], // Define the test file pattern
    moduleFileExtensions: ['js', 'json'], // Recognize these file extensions
    transform: {
        '^.+\\.js$': 'babel-jest', // Use Babel to transform JS files
    },
};
