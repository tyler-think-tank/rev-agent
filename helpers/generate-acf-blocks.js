const fs = require("fs");
const path = require("path");

// Function to capitalize each word in a string
const capitalizeWords = (str) => {
  return str
    .split("-")
    .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
    .join(" ");
};

// Define a mapping between keywords and WordPress Dashicons
const keywordToIconMap = {
  header: "id-alt",
  footer: "id",
  text: "editor-textcolor",
  image: "format-image",
  hero: "megaphone",
  // ... add more mappings as needed
};

// Function to get the most appropriate icon based on keywords
const getIconFromKeywords = (keywords) => {
  for (const keyword of keywords) {
    if (keywordToIconMap[keyword]) {
      return keywordToIconMap[keyword];
    }
  }
  // Default icon if no matching keyword is found
  return "admin-comments";
};

const srcDir = path.join(__dirname, "..", "blocks");
const phpFile = path.join(__dirname, "..", "inc", "acf-blocks.php");

// Check if the PHP file already exists, read it into memory
let existingPhpCode = "";
if (fs.existsSync(phpFile)) {
  existingPhpCode = fs.readFileSync(phpFile, "utf8");
}

let phpCode = "<?php\n\n";

const generateBlockCode = (blockName, blockPath, category) => {
  const keywordsArray = blockName.split("-");
  const icon = getIconFromKeywords(keywordsArray);
  const keywords = keywordsArray.join("', '");
  const title = capitalizeWords(blockName);
  const phpFilePath = `/blocks/${category}/${blockName}/${blockName}.php`;

  const cssFilePath = path
    .join(
      __dirname,
      "..",
      "dist",
      "assets",
      "css",
      category,
      blockName,
      `${blockName}.css`
    )
    .replace(/\\/g, "/");

  const jsFilePath = path
    .join(
      __dirname,
      "..",
      "dist",
      "assets",
      "js",
      category,
      blockName,
      `${blockName}.js`
    )
    .replace(/\\/g, "/");

  // Write debug information to a file to confirm paths
  fs.writeFileSync(
    "debug.txt",
    `Checking existence of CSS file at: ${cssFilePath}\n`,
    { flag: "a" }
  );
  fs.writeFileSync(
    "debug.txt",
    `Checking existence of JS file at: ${jsFilePath}\n`,
    { flag: "a" }
  );

  let enqueueStyleLine = fs.existsSync(cssFilePath)
    ? `'enqueue_style'     => get_template_directory_uri() . '/dist/assets/css/${category}/${blockName}/${blockName}.css',`
    : "";
  let enqueueScriptLine = fs.existsSync(jsFilePath)
    ? `'enqueue_script'    => get_template_directory_uri() . '/dist/assets/js/${category}/${blockName}/${blockName}.js',`
    : "";

  return `
  // Register ${blockName}
  acf_register_block_type(array(
      'name'              => '${title}',
      'title'             => __('${title}'),
      'description'       => __('A custom ${title} block.'),
      'render_callback'   => function(\$block, \$content = '', \$is_preview = false) {
        include(get_theme_file_path('${phpFilePath}'));
      },
      ${enqueueStyleLine}
      ${enqueueScriptLine}
      'category'          => '${category}',
      'icon'              => '${icon}',
      'keywords'          => array( '${keywords}' ),
  ));
  `;
};

const categories = fs.readdirSync(srcDir);
categories.forEach((category) => {
  const blocks = fs.readdirSync(path.join(srcDir, category));
  blocks.forEach((block) => {
    // Check if the block code already exists in the existing PHP file
    if (!existingPhpCode.includes(`'name'              => '${block}',`)) {
      phpCode += generateBlockCode(
        block,
        path.join("assets", category, block),
        category
      );
    }
  });
});

fs.writeFileSync(phpFile, phpCode);
