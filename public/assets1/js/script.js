import {menuEntries} from "./modules/menuEntries.js"
import { createEntry } from "./modules/menu.js";
import { burgerManager } from "./modules/burgerManager.js";
//slider maison
import { initSlider } from "./modules/initSlider.js";
import { sliderCat } from "./modules/sliderCat.js";
globalThis.sliderCat = sliderCat;
globalThis.currentImg = "init";


console.dir(menuEntries);
const navMenu = document.querySelector("#navMenu");
createEntry( menuEntries,navMenu );
burgerManager();
initSlider();