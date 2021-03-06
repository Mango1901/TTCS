/**
 * Copyright © 2017 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
require([
    'jquery',
    'Magenest_MegaMenu/owl-carousel/owl.carousel',
    'domReady!'
], function ($) {
    'use strict';

    $(".magemenu-menu .owl-carousel").each(function (index, el) {
        var config = $(this).data();
        config.navText = ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'];
        config.smartSpeed = "800";

        // if ($.owlCarousel) {
        $(this).owlCarousel(config);
        //}
    });

    $('.action.nav-toggle').click(function () {
        $("html").toggleClass("nav-before-open nav-open");

    });

    $(".parent .ui-menu-icon").click(function () {
        $(this).toggleClass('has-active');
        $(this).parent().toggleClass('has-active');

    });

    $(".btn-menu-vertical").click(function () {
        $(this).parent().children(".vertical-menu").toggleClass("active");
        $("body:not(.cms-index-index)").toggleClass("active-vertical-menu");
    });
    $(document).click(function(event) {
        //Close modal when click outside
        if (
            (!$(event.target).closest(".btn-menu-vertical").length) &&
            (!$(event.target).closest(".magemenu-menu.vertical-menu.active").length) &&
            ($('.magemenu-menu.vertical-menu.active').length)
        ) {
            $("body").find(".magemenu-menu.vertical-menu.active").toggleClass("active");
            $("body:not(.cms-index-index)").toggleClass("active-vertical-menu");
        }
    });
    $('.magemenu-menu ul.explodedmenu > li.itemMenu .menu-collapse').click(function () {
        if ($(window).width() <= 767) {
            $(this).parent('li.itemMenu').toggleClass('active');
        }
    });

    // Event Menu

    $('.nav-magemenu-menu').each(function () {
        if($(window).width() >= 768) {
            if ($(this).hasClass('hover-menu')) {
                //Hover
                $(this).find('.itemMenu').on('mouseenter', function () {
                    var childrenMenu = $(this).children('.itemSubMenu');
                    var animateType = childrenMenu.attr('data-animate');
                    if (childrenMenu.hasClass('animated')) {
                        childrenMenu.addClass(animateType);
                    }
                    childrenMenu.css('display', 'block');
                });
                $(this).find('.itemMenu').on('mouseleave', function () {
                    var childrenMenu = $(this).children('.itemSubMenu');
                    var animateType = childrenMenu.attr('data-animate');
                    if (childrenMenu.hasClass('animated')) {
                        childrenMenu.removeClass(animateType);
                    }
                    childrenMenu.css('display', 'none');
                });

            } else if ($(this).hasClass('click-menu')) {
                //Click
                $(this).find('.itemMenu').on('click', function () {
                    var childrenMenu = $(this).children('.itemSubMenu');
                    var animateType = childrenMenu.attr('data-animate');
                    childrenMenu.toggleClass(animateType);
                    childrenMenu.toggle();
                });
            }
        }

        $('.magemenu-menu.vertical-menu .nav-exploded.explodedmenu > li.itemMenu').on('mouseenter', function () {
            if($(this).children('.itemSubMenu').length) {
                $(this).closest('.magemenu-menu').addClass('items-is-hover');
                $("body.cms-index-index").addClass('active-vertical-menu');
            }
        });

        $('.magemenu-menu.vertical-menu .nav-exploded.explodedmenu > li.itemMenu').on('mouseleave', function () {
            $(this).closest('.magemenu-menu').removeClass('items-is-hover');
            $("body.cms-index-index").removeClass('active-vertical-menu');
        });
    });

    // Menu Tabs
    if ($(window).width() >= 768) {
        $('.parent-tabs-menu > a').hover(function () {
            $(this).parent('.parent-tabs-menu').find('ul.itemsubmenu.subtabs').css('min-height', 'auto');
            $(this).parent('.parent-tabs-menu').find('.subtabs > li').removeClass('active');
            $(this).parent('.parent-tabs-menu').find('.subtabs > li:nth-child(1)').addClass('active');
            $(this).parent('.parent-tabs-menu').find('ul.itemsubmenu.subtabs').css('min-height', $(this).parent('.parent-tabs-menu').find('li.itemMenu.active > .tab-menu-content').outerHeight());
            customCss($(this).parent('.parent-tabs-menu').find('ul.subtabs'));
        });
        $('ul.itemsubmenu.subtabs > li.itemMenu').hover(function () {
            $(this).parent('ul.itemsubmenu.subtabs').css('min-height', 'auto');
            $(this).parent('ul.itemsubmenu.subtabs').children('li.itemMenu').removeClass('active');
            $(this).addClass('active');
            $(this).parent('ul.itemsubmenu.subtabs').css('min-height', $(this).children('.tab-menu-content').outerHeight());
            customCss($(this).parent('ul.subtabs'));
        });
    } else {
        $('ul.itemsubmenu.subtabs > li.itemMenu').click(function () {
            $(this).parent('ul.itemsubmenu.subtabs').children('li.itemMenu').removeClass('active');
            $(this).addClass('active');
            customCss($(this).parent('ul.subtabs'));
        });
    };
    function customCss(ulTabs){
        $(ulTabs.children('li.itemMenu')).each(function(){
            if($(this).hasClass('active')){
                $(this).children('a').css({
                    'color':$(this).attr('data-color-hover'),
                    'background-color':$(this).attr('data-background-hover')
                });
            } else{
                $(this).children('a').css({
                    'color':$(this).attr('data-color'),
                    'background-color':$(this).attr('data-background')
                });
            }
        });
    };


    //Fixed Menu
    $('.nav-magemenu-menu').each(function () {
        if($(this).hasClass('fixed-menu')){
           var nav_megamenu = $(this);
           var position_of_megamenu = $(this).position().top;
           function addFixedClass(){
               if($(document).scrollTop() >= position_of_megamenu){
                   nav_megamenu.addClass('fixed');
               }else{
                   nav_megamenu.removeClass('fixed');
               }
           }
           $(document).scroll(function () {
               if($(window).width() >= 768) {
                   addFixedClass();
               }
           });
           $(document).ready(function () {
               if($(window).width() >= 768) {
                   addFixedClass();
               }
           });
        }
    });
});