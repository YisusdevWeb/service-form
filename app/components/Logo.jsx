import React from 'react'
import { Box } from '@mui/material';

const Logo = () => {
  // Obtener logo y dimensiones desde WordPress
  const customLogoUrl = window.FSF_data?.logo_url || '';
  const logoMaxWidth = window.FSF_data?.logo_max_width || '200';
  const logoMaxHeight = window.FSF_data?.logo_max_height || '80';
  const defaultLogo = "https://dappin.pt/wp-content/uploads/2024/01/dappin_logo-768x177.png";
  
  return (
    <Box
      component="img"
      sx={{
        maxWidth: `${logoMaxWidth}px`,
        maxHeight: `${logoMaxHeight}px`,
        width: 'auto',
        height: 'auto',
        objectFit: 'contain',
        mx: 'auto',
        display: 'block',
        marginBottom: '16px',
      }}
      alt="Logo"
      src={customLogoUrl || defaultLogo}
      className="logo-image"
    />
  );
};

export default Logo;
