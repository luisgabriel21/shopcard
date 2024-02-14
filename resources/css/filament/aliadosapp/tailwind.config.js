import preset from '../../../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/Aliadosapp/**/*.php',
        './resources/views/filament/aliadosapp/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        './vendor/awcodes/filament-curator/resources/**/*.blade.php',
    ],
}
/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './pages/**/*.{html,js}',
    './components/**/*.{html,js}',
  ],
  // ...
}
