/*
 * Bootstrap Portfolio
 * Portfolio website of Jelle Van Goethem.
 * Copyright (C) 2024 Jelle Van Goethem
 *
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation, either version 3 of the License, or (at your option)
 * any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for
 * more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * this program. If not, see <http://www.gnu.org/licenses/>.
 */

/*
 * Script to hide the navbar hamburger menu when a navbar hamburger menu link is clicked,
 * or when the window gets resized in a way that would turn the hamburger menu into a normal
 * navbar and back into a hamburger menu, while the hamburger menu was shown before resizing.
 */

import { debounce } from './utils.js';

/**
 * The Bootstrap medium breakpoint (md) in pixels.
 * @type {number}
 */
const BOOTSTRAP_MEDIUM_BREAKPOINT = 768;
const COLLAPSE = bootstrap.Collapse;

document.addEventListener('DOMContentLoaded', () => {
    const body = document.body;
    const navMenu = document.getElementById('navMenu');
    const navMenuCollapseInstance = COLLAPSE.getOrCreateInstance(navMenu, { toggle: false });

    const hideNavHamburgerMenu = () => navMenuCollapseInstance.hide();
    const hideNavHamburgerMenuWithoutAnimation = () => navMenu.classList.remove('show');

    const isNavHamburgerMenuOpen = () => navMenu.classList.contains('show');
    const isNavbarHamburgerMenu = () => window.innerWidth < BOOTSTRAP_MEDIUM_BREAKPOINT;

    const handleNavHamburgerMenuHidingOnBodyClick = (event) => {
        const clickedElementClassName = event.target.className;
        /*
         * Dynamically get class names from denied elements, by id, to ensure
         * that the class names are correct, even if the class names change.
         */
        const navbarClassName = document.getElementById('navbar').className;
        const navbarContainerClassName = document.getElementById('navbarContainer').className;
        const elementDenyHideList = [navbarClassName, navbarContainerClassName];

        if (elementDenyHideList.includes(clickedElementClassName)) return;

        hideNavHamburgerMenu();
    };

    const addClickListenerToBody = () => {
        body.addEventListener('click', handleNavHamburgerMenuHidingOnBodyClick);
    };
    const removeClickListenerFromBody = () => {
        body.removeEventListener('click', handleNavHamburgerMenuHidingOnBodyClick);
    };

    const addCollapseListenersToNavMenu = () => {
        navMenu.addEventListener('show.bs.collapse', addClickListenerToBody);
        navMenu.addEventListener('hide.bs.collapse', removeClickListenerFromBody);
    };
    const removeCollapseListenersFromNavMenu = () => {
        navMenu.removeEventListener('show.bs.collapse', addClickListenerToBody);
        navMenu.removeEventListener('hide.bs.collapse', removeClickListenerFromBody);
    };

    const onWindowResize = () => {
        if (isNavbarHamburgerMenu()) addCollapseListenersToNavMenu();
        else {
            removeCollapseListenersFromNavMenu();

            /*
             * Hide the navbar hamburger menu when the window width exceeds the medium (md)
             * breakpoint (hamburger menu turns into normal navbar) while the navbar menu is
             * shown (in the background) to prevent the navbar hamburger menu from being shown
             * after resizing in a way that would turn the navbar back into a hamburger menu.
             */
            if (isNavHamburgerMenuOpen()) hideNavHamburgerMenuWithoutAnimation();
        }
    };

    if (isNavbarHamburgerMenu()) addCollapseListenersToNavMenu();

    window.addEventListener('resize', debounce(onWindowResize, 125));
});
