
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

window.draggable = draggable;
window.wpsong = wpsong;
window.LyricLineDetect = LyricLineDetect;
window.wpform  = wpform;
window.manageteammembers  = manageteammembers;
window.manageservices  = manageservices;
window.manageauthors  = manageauthors;
window.managebandroles  = managebandroles;


  $(function(){

    
    $('select').material_select();
    $('.button-collapse').sideNav();
    $('.modal').modal();
    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15, // Creates a dropdown of 15 years to control year
        onStart: () => {
          $('.picker').appendTo('body');
        }
    });

    $('ul.tabs').tabs();

    window.setTimeout(function () {
        $('.alert-box').fadeOut('slow');
    }, 5000);
    
    

  }); // end of document ready

