/**
 * Gutenberg Blocks
 *
 * All blocks related JavaScript files should be imported here.
 * You can create a new block folder in this dir and include code
 * for that block here as well.
 *
 * All blocks should be included here since this is the file that
 * Webpack is compiling as the input file.
 */
import Icon from './components/Icon.jsx';
import './section/section.js';
import './section-jets/section-jets.js';
import './section-customers/section-customers.js';
import './section-jet-types/section-jet-types.js';
import './section-parallax/section-parallax.js';
import './jet-title/jet-title.js';
import './jet-stats/jet-stats.js';
import './section-blank/section.js';
import './jet-gallery/jet-gallery.js';
import './stats/stats.js';
import './customers/customers.js';

import './styles/admin.scss';
import './styles/style.scss';

wp.blocks.updateCategory('aerolinea-blocks', {
  icon: <Icon className="block-category-icon" icon="i-airplane" />
});
