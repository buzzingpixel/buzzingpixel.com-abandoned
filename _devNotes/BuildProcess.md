# Using the build process

## Requirements

### Node.js and NPM

You'll need to have Node and NPM installed and working in your command line.

## Building the project

- Before running the build for the first time, you'll need to CD to this project in the command line and run `npm install`
- To build the project and watch for changes CD to this project in the command line and run `npm install`
- To stop watching the project, type the interrupt key signal: `ctrl + c`

## Notes

- All front end build assets live in the `assetsSource` directory.
- CSS is built from the PostCSS files (`.pcss`).
    - `reset.pcss` is built before all your other custom styles
- Javascript is compiled into a single JS file from your javascript files.
    - `setup.js` is built before anything else
    - `main.js` is built after everything else
- Any files in `fonts`, `img` and `lib` is copied to the same location in `public/assets`
- The build process lints the JavaScript files against our JSCS and JSHint standards and warns you of any problems so be sure to pay attention to that. It's easier to keep with the standards as you write code than it is to go back and fix later.
- Unless you override the `proxy` key in projectOverrides.json as `false`, the project will proxy the site's dev URL, open it in your default browser, and live reload JS, CSS, Template, and src changes.
