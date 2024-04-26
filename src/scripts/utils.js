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

/**
 * A debounce function will delay calling a function until after the specified
 * delay has passed since the last time it was invoked. If the debounced function
 * is invoked again before the delay has passed, it resets the delay.
 *
 * @param {Function} func - The function to debounce.
 * @param {number} delay - The delay in milliseconds.
 *
 * @returns {Function} The debounced function.
 */
export function debounce(func, delay) {
    let timeoutId = null;

    return function (...args) {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => func.apply(this, args), delay);
    };
}
