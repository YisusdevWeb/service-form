import { styled, alpha } from '@mui/material/styles';
import InputBase from '@mui/material/InputBase';

const BootstrapInput = styled(InputBase)(({ theme }) => ({
  'label + &': {
    marginTop: theme.spacing(0),
    marginBottom: theme.spacing(2),
    position: 'relative', // Asegura que el label tenga posición relativa
  },
  '& .MuiInputBase-input': {
    borderRadius: 0,
    position: 'relative',
    backgroundColor: 'transparent',
    border: 'none',
    borderBottom: '1px solid #ffffff',
    margin: 0,
    fontSize: 16,
    width: '100%',
    padding: '10px 0', // Reduced horizontal padding for standard look
    color: 'var(--input-text, #ffffff)',
    transition: theme.transitions.create([
      'border-color',
      'background-color',
      'box-shadow',
    ]),
    fontFamily: 'Poppins, sans-serif', // Asegura la fuente correcta,
    '&:focus': {
      boxShadow: 'none',
      borderColor: theme.palette.primary.main,
      borderBottom: `2px solid ${theme.palette.primary.main}`,
    },
  },
}));

export default BootstrapInput;
