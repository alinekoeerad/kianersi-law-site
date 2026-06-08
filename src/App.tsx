import React, { Suspense } from 'react';
import Navbar from "./components/Navbar";
import HeroSection from "./components/HeroSection";
import Footer from "./components/Footer";
import BackToTop from "./components/BackToTop";

const AboutSection = React.lazy(() => import('./components/AboutSection'));
const ExpertiseSection = React.lazy(() => import('./components/ExpertiseSection'));
const DistinguishingSection = React.lazy(() => import('./components/DistinguishingSection'));
const LawsSection = React.lazy(() => import('./components/LawsSection'));
const ContactSection = React.lazy(() => import('./components/ContactSection'));

const SectionLoader = () => (
  <div className="flex justify-center items-center py-20">
    <div className="w-8 h-8 rounded-full animate-spin" 
         style={{ border: '2px solid rgba(14,116,144,0.2)', borderTopColor: '#7dd3fc' }}>
    </div>
  </div>
);

export default function App() {
  return (
    <div className="min-h-screen paper-texture bg-deep" style={{ color: '#ffffff' }}>
      <Navbar />
      <HeroSection />

      <Suspense fallback={<SectionLoader />}>
        <AboutSection />
        <ExpertiseSection />
        <DistinguishingSection />
        <LawsSection />
        <ContactSection />
      </Suspense>

      <Footer />
      <BackToTop />
    </div>
  );
}