import React from 'react';
import { Outlet, Link, useLocation } from 'react-router-dom';
import { Menu, X } from 'lucide-react';
import logo from '../assets/img/ugsel_logo.png';
import './Layout.css';

const Layout = () => {
    const [isMenuOpen, setIsMenuOpen] = React.useState(false);
    const location = useLocation();

    const toggleMenu = () => setIsMenuOpen(!isMenuOpen);

    const isActive = (path) => {
        if (path === '/') return location.pathname === '/' ? 'active' : '';
        return location.pathname.startsWith(path) ? 'active' : '';
    };

    return (
        <div className="layout">
            <header className="header">
                <div className="container header-content">
                    <Link to="/" className="logo">
                        <img src={logo} alt="UGSEL 35" className="logo-img" />
                    </Link>

                    <button className="menu-toggle" onClick={toggleMenu}>
                        {isMenuOpen ? <X /> : <Menu />}
                    </button>

                    <nav className={`nav ${isMenuOpen ? 'open' : ''}`}>
                        <Link to="/" className={`nav-link ${isActive('/')}`} onClick={() => setIsMenuOpen(false)}>
                            Accueil
                        </Link>
                        <Link to="/sports" className={`nav-link ${isActive('/sports')}`} onClick={() => setIsMenuOpen(false)}>
                            Sports
                        </Link>
                        <Link to="/championnats" className={`nav-link ${isActive('/championnats')}`} onClick={() => setIsMenuOpen(false)}>
                            Championnats
                        </Link>
                        <Link to="/gestion" className={`nav-link ${isActive('/gestion')}`} onClick={() => setIsMenuOpen(false)}>
                            Gestion
                        </Link>
                    </nav>
                </div>
            </header>

            <main className="main-content container">
                <Outlet />
            </main>

            <footer className="footer">
                <div className="container footer-content">
                    <p>&copy; {new Date().getFullYear()} UGSEL 35 - Comité Départemental</p>
                </div>
            </footer>
        </div>
    );
};

export default Layout;
