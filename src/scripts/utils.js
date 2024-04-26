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
 * Script to close the navbar menu when a navbar hamburger menu link is clicked.
 */

document.addEventListener('DOMContentLoaded', () => {
    const navHamburgerMenuButton = document.getElementById('navHamburgerMenuButton');
    const navMenu = document.getElementById('navMenu');
    const navMenuLinks = navMenu.querySelectorAll('a');

    /**
     * Closes the navbar hamburger menu.
     *
     * Despite this function using the toggle() function, it will always close the navbar menu
     * because this function only gets called when the navbar menu is open,
     * meaning this function will technically always close the menu.
     */
    const closeNavHamburgerMenu = () => {
        bootstrap.Collapse.getOrCreateInstance(navMenu, { toggle: false }).toggle();
    };
    const forceCloseNavHamburgerMenu = () => {
        navMenu.classList.remove('show');
        navHamburgerMenuButton.classList.add('collapsed');
    };

    const isHamburgerNavMenuOpen = () => navMenu.classList.contains('show');
    const isNavMenuHamburger = () => window.innerWidth < 768; /* Bootstrap medium (md) breakpoint = ≥768px */

    /* Add event listeners when the navbar menu is shown */
    navMenu.addEventListener('show.bs.collapse', () => {
        navMenuLinks.forEach((navMenuLink) => {
            navMenuLink.addEventListener('click', closeNavHamburgerMenu);
        });
    });

    /* Remove event listeners when the navbar menu is hidden */
    navMenu.addEventListener('hide.bs.collapse', () => {
        /*
         * Remove listeners to fix issue where clicking navbar links will
         * visually toggle the navbar menu in non-hamburger button mode.
         */
        navMenuLinks.forEach((navMenuLink) => {
            navMenuLink.removeEventListener('click', closeNavHamburgerMenu);
        });
    });

    /*
     * Force close the navbar hamburger menu when the window width exceeds the medium (md) breakpoint
     * (hamburger menu turns into normal navbar) and the navbar menu is open (in the background).
     * Using closeNavMenu's approach isn't possible in this scenario.
     *
     * By doing this, we prevent the navbar menu from being open after the menu was open and the
     * window width increased (making hamburger menu turn into normal navbar) and decreased again
     * (navbar would turn into OPEN hamburger menu), e.g. resizing the window.
     */
    window.addEventListener('resize', () => {
        if (!isNavMenuHamburger() && isHamburgerNavMenuOpen()) {
            forceCloseNavHamburgerMenu();
        }
    });
});
