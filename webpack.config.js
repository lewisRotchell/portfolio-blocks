const defaultConfig = require("@wordpress/scripts/config/webpack.config");
const path = require("path");
const fs = require("fs");

const blockPath = path.resolve(__dirname, "src");

const createBlockEntryPoints = () => {
  const entryPoints = {};
  const blocks = fs.readdirSync(blockPath);

  blocks.forEach((block) => {
    const blockFrontendPath = path.resolve(blockPath, block, "frontend.js");

    if (fs.existsSync(blockFrontendPath)) {
      entryPoints[`${block}/frontend`] = blockFrontendPath;
    }
  });

  return entryPoints;
};

const { getWebpackEntryPoints } = require("@wordpress/scripts/utils/config");

const customConfig = {
  ...defaultConfig,
  entry: {
    ...getWebpackEntryPoints(),
    ...createBlockEntryPoints(),
  },
};

module.exports = customConfig;
