global.$ = global.jQuery = require('jquery');
// jest.setup.js
const { TextEncoder, TextDecoder } = require('util');

global.TextEncoder = TextEncoder;
global.TextDecoder = TextDecoder;
