import { createTheme } from '@mui/material/styles';

const theme = createTheme({
  typography: {
    fontFamily: 'Poppins, sans-serif', // Define Poppins como la fuente global
  },
  palette: {
    primary: {
      main: '#0f4c80',
    },
    secondary: {
      main: '#e6e6e6',
    },
    background: {
      default: '#f9f9f9',
    },
    text: {
      primary: '#0009',
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
    MuiDialogTitle: {
      styleOverrides: {
        root: {
          fontFamily: 'Poppins, sans-serif',
          color: 'var(--heading-color)',
        },
      },
    },
    MuiDialogContentText: {
      styleOverrides: {
        root: {
          fontFamily: 'Poppins, sans-serif',
          color: 'var(--font-color)',
        },
      },
    },
    MuiStepIcon: {
      styleOverrides: {
        root: {
          color: 'var(--assistant-color)',
          '&.Mui-active': {
            color: 'var(--theme-color-darken)',
          },
          '&.Mui-completed': {
            color: 'var(--theme-color)',
          },
        },
      },
    },
  },
});

export default theme;
