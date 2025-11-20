import { createTheme } from '@mui/material/styles';

const theme = createTheme({
  typography: {
    fontFamily: 'Poppins, sans-serif',
    allVariants: {
      color: '#ffffff',
    },
  },
  palette: {
    mode: 'dark',
    primary: {
      main: '#1e5a8e',
      light: '#3a7bc8',
      dark: '#0a1929',
    },
    secondary: {
      main: '#e5e7eb',
    },
    background: {
      default: 'transparent',
      paper: 'transparent',
    },
    text: {
      primary: '#ffffff',
      secondary: '#e5e7eb',
    },
  },
  components: {
    MuiButton: {
      styleOverrides: {
        root: {
          fontFamily: 'Poppins, sans-serif',
        },
      },
    },
    MuiInputLabel: {
      styleOverrides: {
        root: {
          color: '#ffffff !important',
          fontWeight: 500,
          '&.Mui-focused': {
            color: '#ffffff !important',
          },
          '&.MuiInputLabel-shrink': {
            color: '#ffffff !important',
          },
        },
      },
    },
    MuiFormLabel: {
      styleOverrides: {
        root: {
          color: '#ffffff !important',
          '&.Mui-focused': {
            color: '#ffffff !important',
          },
        },
      },
    },
    MuiTypography: {
      styleOverrides: {
        root: {
          color: '#ffffff',
        },
        h1: {
          color: '#ffffff !important',
        },
        h2: {
          color: '#ffffff !important',
        },
        h3: {
          color: '#ffffff !important',
        },
        h4: {
          color: '#ffffff !important',
        },
        h5: {
          color: '#ffffff !important',
        },
        h6: {
          color: '#ffffff !important',
        },
        body1: {
          color: '#ffffff !important',
        },
        body2: {
          color: '#e5e7eb !important',
        },
      },
    },
    MuiDialogTitle: {
      styleOverrides: {
        root: {
          fontFamily: 'Poppins, sans-serif',
          color: '#ffffff',
        },
      },
    },
    MuiDialogContentText: {
      styleOverrides: {
        root: {
          fontFamily: 'Poppins, sans-serif',
          color: '#ffffff',
        },
      },
    },
    MuiStepIcon: {
      styleOverrides: {
        root: {
          color: 'rgba(255, 255, 255, 0.3)',
          '&.Mui-active': {
            color: '#ffffff !important',
          },
          '&.Mui-completed': {
            color: '#ffffff !important',
          },
        },
      },
    },
    MuiFormControlLabel: {
      styleOverrides: {
        root: {
          color: '#ffffff !important',
        },
        label: {
          color: '#ffffff !important',
        },
      },
    },
  },
});

export default theme;
