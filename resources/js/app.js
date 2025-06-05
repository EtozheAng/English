import '../sass/app.scss';
import './bootstrap';
// import './images-card'

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { BaseGame } from './base-game.js';

window.BaseGame = BaseGame;
