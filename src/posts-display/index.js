import { registerBlockType } from "@wordpress/blocks";

import "./style.scss";
import "./editor.scss";

import edit from "./edit";
import save from "./save";

registerBlockType("portfolio-theme-blocks/posts-display", {
  edit,
  save,
});
