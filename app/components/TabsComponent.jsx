import React from 'react';
import { Box, Tabs, Tab, Paper,Typography,Button } from "@mui/material";

const TabPanel = ({ children, value, index }) => {
  return (
    <div
      role="tabpanel"
      hidden={value !== index}
      id={`tabpanel-${index}`}
      aria-labelledby={`tab-${index}`}
      className="tab-panel"
    >
      {value === index && <Box p={3}>{children}</Box>}
    </div>
  );
};

const TabsComponent = ({ tabs, value, handleChange, onEditSelections, onAddMoreServicesAndScroll }) => (
    <Box display="flex" flexDirection="column" alignItems="center" sx={{ padding: '25px 10px 0px 10px'}}>
      <Box sx={{ width: "100%", mb: 2 }}>
        <Box sx={{ borderBottom: 1, borderColor: "var(--border-color)" }}>
          <Tabs
            value={value}
            onChange={handleChange}
            aria-label="Summary Tabs"
            variant="scrollable"
            scrollButtons="auto"
          >
            {tabs.map(tab => (
              <Tab
                key={tab.uniqueServiceId}
                label={tab.serviceTitle}
                sx={{
                  fontFamily: "Poppins, sans-serif",
                  fontWeight: "bold",
                  fontSize: "1rem",
                  color: "#ffffff !important",
                  textTransform: "uppercase",
                  padding: "8px 16px",
                  '&.Mui-selected': {
                    color: "#ffffff !important",
                    backgroundColor: "var(--theme-color)",
                    fontSize: "1.1rem",
                  },
                  '&:hover': {
                    color: "#ffffff !important",
                    backgroundColor: "var(--theme-color-darken)",
                  },
                }}
              />
            ))}
          </Tabs>
        </Box>
        {tabs.map((tab, index) => (
          <TabPanel key={tab.uniqueServiceId} value={value} index={index}>
            <Paper className="tab-panel">
              {tab.phases.map(({ phaseId, phaseTitle, phaseSelections }) => (
                <Box key={phaseId} mb={2}>
                  <Typography variant="h6" className="phase-title">{phaseTitle}</Typography>
                  <ul>
                    {Object.entries(phaseSelections).map(([option, selected]) =>
                      selected && option !== "phaseTitle" ? <li key={option}>{option}</li> : null
                    )}
                  </ul>
                </Box>
              ))}
            </Paper>
            <Box className="buttons">
              <Button onClick={() => onEditSelections(tab.uniqueServiceId)} className="custom-button">
                <span className="title-btn" data-animate-text="EDITAR SERVIÇO">EDITAR SERVIÇO</span>
              </Button>
              <Button onClick={onAddMoreServicesAndScroll} className="custom-button">
                <span className="title-btn" data-animate-text="ADICIONAR SERVIÇO">ADICIONAR SERVIÇO</span>
              </Button>
            </Box>
          </TabPanel>
        ))}
      </Box>
    </Box>
  
);

export default TabsComponent;
