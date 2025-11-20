import React from 'react'
import { Box } from '@mui/material';

const Logo = ({ width = "38%", height = "auto" }) => {
  // Obtener logo personalizado desde WordPress (si existe)
  const customLogoUrl = window.FSF_data?.logo_url || '';
  const defaultLogo = "https://dappin.pt/wp-content/uploads/2024/01/dappin_logo-768x177.png";
  
  return (
    <Box
      component="img"
      sx={{
        width: width,
        height: height,
        mx: 'auto',
        display: 'block',
        marginBottom: '16px',
      }}
      alt="Logo"
      src={customLogoUrl || defaultLogo}
      className="logo-container"
    />
  );
};

export default Logo;
