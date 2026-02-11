import React, { useState, useRef, useEffect } from 'react';
import { ChevronDown, Check } from 'lucide-react';
import './Select.css';

const Select = ({ value, onChange, options, placeholder = 'Sélectionner...', className = '' }) => {
    const [isOpen, setIsOpen] = useState(false);
    const containerRef = useRef(null);

    const selectedOption = options.find(opt => opt.value === value);

    useEffect(() => {
        const handleClickOutside = (event) => {
            if (containerRef.current && !containerRef.current.contains(event.target)) {
                setIsOpen(false);
            }
        };

        document.addEventListener('mousedown', handleClickOutside);
        return () => document.removeEventListener('mousedown', handleClickOutside);
    }, []);

    const handleSelect = (optionValue) => {
        onChange(optionValue);
        setIsOpen(false);
    };

    return (
        <div className={`custom-select-container ${className}`} ref={containerRef}>
            <button
                type="button"
                className={`custom-select-trigger ${isOpen ? 'open' : ''}`}
                onClick={() => setIsOpen(!isOpen)}
            >
                <span>{selectedOption ? selectedOption.label : placeholder}</span>
                <ChevronDown size={16} className={`select-arrow ${isOpen ? 'open' : ''}`} />
            </button>

            {isOpen && (
                <div className="custom-select-options">
                    {options.map((option) => (
                        <div
                            key={option.value}
                            className={`custom-select-option ${value === option.value ? 'selected' : ''}`}
                            onClick={() => handleSelect(option.value)}
                        >
                            <span>{option.label}</span>
                            {value === option.value && <Check size={16} className="check-icon" />}
                        </div>
                    ))}
                </div>
            )}
        </div>
    );
};

export default Select;
