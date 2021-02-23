import "@theme/front/init.scss";


import "lightbox2/dist/css/lightbox.css";
import lightbox from "lightbox2/dist/js/lightbox";


import "./front/netteForms";
import "./front/lazysizes";
import "bootstrap/js/dist/carousel";

import "bootstrap/js/dist/button";
import "bootstrap/js/dist/dropdown";
import "bootstrap/js/dist/collapse";

// naja
import naja from "naja";
document.addEventListener("DOMContentLoaded", () => naja.initialize());

// jquery
import "jquery/dist/jquery.min";
// import "@/front/cookie";

import Nette from "@/front/netteForms";
Nette.initOnLoad();
window.Nette = Nette;

window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag("js", new Date());

gtag("config", "G-7ZCRCBXDYX");

document.addEventListener("DOMContentLoaded", () => {
});

