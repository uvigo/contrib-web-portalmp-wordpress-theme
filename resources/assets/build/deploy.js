const path = require('path')
const fs = require('fs-extra')
const zip = require('bestzip');

// Base path
const basePath = path.resolve('./') + '/'
const baseFolder = 'uvigothemewp' + '/'

// Package read
const package = require(basePath + 'package.json');

// Array with files and folders
const sources = [
  'style.css',
  'functions.php',
  'index.php',
  'screenshot.png',
  'README.md',
  'CHANGELOG.md',
  'LICENSE.md',
  'app',
  'config',
  'dist',
  'languages',
  'templates',
  'vendor',
  'views',
];

const excludedFiles = ['.DS_Store'];

// console.log(basePath + baseFolder);

const filterFunc = (src, dest) => {
  return ! excludedFiles.includes(path.basename(src));
}

// Remove folder to recreate
fs.remove(basePath + baseFolder)
.then(() => {
  console.log('Deleted old folder success!')

  fs.ensureDir(basePath + baseFolder)
  .then(() => {
    console.log('New folder created success!')

    let pending = sources.length

    sources.forEach(function(item) {
      const itemSource = basePath + item
      const itemDestination = basePath + baseFolder + item
      fs.copy(itemSource, itemDestination, { filter: filterFunc })
      .then(() => {
        console.log(`Copied '${item}' success!`)
        if (!--pending) zipFile();
      })
      .catch(err => {
        console.error(err)
      })
    });
  })
  .catch(err => {
    console.error(err)
  })
})
.catch(err => {
  console.error(err)
})

function zipFile() {
  zip('./uvigothemewp-v' + package.version + '.zip', ['uvigothemewp/'], function(err) {
    if  (err) {
      console.error(err.stack);
      process.exit(1);
    } else {
      console.log('Zip created');

      fs.remove(basePath + baseFolder)
      .then(() => {
        console.log('All done!');
      })
      .catch(err => {
        console.error(err)
      })
    }
  });
}
