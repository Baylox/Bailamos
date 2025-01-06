import React from "react";
import { createRoot } from "react-dom/client"; // Import de la nouvelle API React 18+

// Import du composant React
import DanceCarousel from "./js/components/DanceCarousel";

// Import des styles
import './styles/app.scss';

// Import des dépendances tierces
import 'bootstrap';
import AOS from 'aos';
import 'aos/dist/aos.css';

// Initialisation des dépendances
AOS.init({});

// Recherche de l'élément où React sera monté
const rootElement = document.getElementById('react-root');

if (rootElement) {
  // Utilise createRoot pour initialiser et rendre React
  const root = createRoot(rootElement); 
  root.render(<DanceCarousel />);
}
