import React from 'react'
import { Box } from '@mui/material';

const Logo = ({ width = "38%", height = "auto" }) => (
<Box
component="img"
sx={{
  width: width,
  height: height,
  mx: 'auto',
  display: 'block',
  marginBottom: '16px',
}}
alt="Dappin Logo"
src="https://dappin.pt/wp-content/uploads/2024/01/dappin_logo-768x177.png"
/>

);

export default Logo;
