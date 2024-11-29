import React from 'react';
import { Button, Box } from '@mui/material';

const MultipleChoiceOption = ({ option, isSelected, handleSelection }) => {
  return (
    <Button
      variant={isSelected ? 'contained' : 'outlined'}
      onClick={handleSelection}
      sx={{
        flex: '1 1 calc(50% - 16px)',
        minWidth: '120px',
        textTransform: 'none',
        '@media (max-width: 600px)': {
          flex: '1 1 100%',
        },
      }}
    >
      {option.titulo}
    </Button>
  );
};

export default MultipleChoiceOption;
