// 3rd party packages from NPM
import $ from 'jquery';
import slick from 'slick-carousel';
import lightbox from 'lightbox2';


// Our modules / classes
/*import GoogleMap from './modules/GoogleMap';*/
/*import frontEndUpload from './modules/frontEndUpload';
*/

import Like from './modules/Like';
import DeleteImage from './modules/DeleteImage';
import UserQuestions from './modules/UserQuestions';
import Gallery from './modules/Gallery';

// Instantiate a new object using our modules/classes

/*var googleMap = new GoogleMap();*/
/*var gallery = new frontEndUpload();*/

var deleteImage = new DeleteImage();
var like = new Like();
var userQuestions = new UserQuestions();
var gallery = new Gallery();