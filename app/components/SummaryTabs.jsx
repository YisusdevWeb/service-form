import React from 'react';
import { Tabs, Tab, Box, Typography, Paper } from '@mui/material';
import useStore from '../store/store.js';

const TabPanel = ({ children, value, index, ...other }) => {
  return (
    <div
      role="tabpanel"
      hidden={value !== index}
      id={`tabpanel-${index}`}
      aria-labelledby={`tab-${index}`}
      {...other}
    >
      {value === index && (
        <Box p={3}>
          {children}
        </Box>
      )}
    </div>
  );
};

const SummaryTabs = () => {
  const { selections } = useStore();
  const [value, setValue] = React.useState(0);
  const handleChange = (event, newValue) => {
    setValue(newValue);
  };

  // Assuming we have a way to get the titles of the completed services from the selections or another store
  const completedServices = Object.entries(selections).map(([serviceId, serviceSelections]) => {
    // Obtain the service title from the selections or another source
    const serviceTitle = serviceSelections.serviceTitle || `Servicio ${serviceId}`;
    const phases = Object.entries(serviceSelections).map(([phaseId, phaseSelections]) => {
      const phaseTitle = phaseSelections.phaseTitle || `Fase ${parseInt(phaseId) + 1}`;
      return { phaseId, phaseTitle, phaseSelections };
    });
    return { serviceId, serviceTitle, phases };
  });

  return (
    <Box sx={{ width: '100%' }}>
      <Tabs value={value} onChange={handleChange} aria-label="Summary Tabs">
        {completedServices.map((service, index) => (
          <Tab key={service.serviceId} label={service.serviceTitle} />
        ))}
      </Tabs>
      {completedServices.map((service, index) => (
        <TabPanel key={service.serviceId} value={value} index={index}>
          <Paper sx={{ p: 3, backgroundColor: '#e6e6e6', borderRadius: 2, mb: 2 }}>
            <Typography variant="h6" sx={{ color: '#0f4c80', fontWeight: 'bold' }}>
              {service.serviceTitle}
            </Typography>
            {service.phases.map(({ phaseId, phaseTitle, phaseSelections }) => (
              <Box key={phaseId} mb={2}>
                <Typography variant="h6" sx={{ color: '#0f4c80', fontWeight: 'bold' }}>{phaseTitle}</Typography>
                <ul style={{ listStyleType: 'none', padding: 0 }}>
                  {Object.entries(phaseSelections).map(([option, selected]) => (
                    selected ? <li key={option}>{option}</li> : null
                  ))}
                </ul>
              </Box>
            ))}
          </Paper>
        </TabPanel>
      ))}
    </Box>
  );
};

export default SummaryTabs;
