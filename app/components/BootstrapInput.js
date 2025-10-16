import { styled, alpha } from '@mui/material/styles';
import InputBase from '@mui/material/InputBase';

const BootstrapInput = styled(InputBase)(({ theme }) => ({
  'label + &': {
    marginTop: theme.spacing(0),
    marginBottom: theme.spacing(2),
    position: 'relative', // Asegura que el label tenga posición relativa
  },
  '& .MuiInputBase-input': {
    borderRadius: 4,
    position: 'relative',
    backgroundColor: '#fff',
    border: '1px solid #E0E3E7',
    margin: 0,
    fontSize: 16,
    width: '100%',
    padding: '10px 12px',
    transition: theme.transitions.create([
      'border-color',
      'background-color',
      'box-shadow',
    ]),
    fontFamily: 'Poppins, sans-serif', // Asegura la fuente correcta,
    '&:focus': {
      boxShadow: `${alpha(theme.palette.primary.main, 0.2)} 0 0 0 0.1rem`,
      borderColor: theme.palette.primary.main,
    },
  },
}));

export default BootstrapInput;
