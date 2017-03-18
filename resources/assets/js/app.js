
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import draggable from 'vuedraggable';
import { LyricLineDetect } from './LyricLineDetect';
import wpsong from './components/Wpsong.vue';
import wpform from './components/WPform.vue';
import manageteammembers from './components/ManageTeamMembers.vue';
import manageservices from './components/ManageServices.vue';
import manageauthors from './components/ManageAuthors.vue';
import managebandroles from './components/ManageBandRoles.vue';
import managebands from './components/ManageBands.vue';

window.draggable = draggable;
window.wpsong = wpsong;
window.LyricLineDetect = LyricLineDetect;
window.wpform  = wpform;
window.manageteammembers  = manageteammembers;
window.manageservices  = manageservices;
window.manageauthors  = manageauthors;
window.managebandroles  = managebandroles;
window.managebands  = managebands;

