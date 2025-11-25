import React, { useState, useEffect, useRef } from "react";
import { Box, Typography, Paper, Button } from "@mui/material";
import Logo from "../components/Logo"; // Importa el componente Logo
import TabsComponent from "../components/TabsComponent"; // Importa el componente TabsComponent
import { useForm } from "react-hook-form";
import useStore from "../store/store.js";
import SuccessMessage from "../components/SuccessMessage";
import { useNavigate } from "react-router-dom"; // Importa useNavigate
import "../../assets/scss/styles.scss";

const SummaryForm = ({ onEditSelections, onAddMoreServices, userData }) => {
  const { handleSubmit, reset } = useForm();
  const { selections } = useStore();
  const [value, setValue] = useState(0);
  const [showSuccess, setShowSuccess] = useState(false);
  const apiBaseUrl = FSF_data.api_base_url.user_info;
  const formRef = useRef(null);
  const navigate = useNavigate(); // Get navigation function

  const handleChange = (event, newValue) => setValue(newValue);
  const handleAddMoreServicesAndScroll = () => {
    onAddMoreServices();
    scrollToForm();
  };

  const scrollToForm = () => {
    if (formRef.current) {
      formRef.current.scrollIntoView({ behavior: "smooth" });
    }
  };
  const onSubmit = async () => {
    const finalData = { ...userData, selections };
  
    try {
      console.log("Final Data:", finalData);
      const apiUrl = `${apiBaseUrl}/${userData.post_id}`;
      console.log("API URL:", apiUrl);
  
      const headers = { "Content-Type": "application/json" };
      if (FSF_data?.nonce) headers['X-WP-Nonce'] = FSF_data.nonce;

      const response = await fetch(apiUrl, {
        method: "POST",
        headers,
        body: JSON.stringify(finalData),
      });

      // If server expects nonce, re-run request with nonce in header (some environments may require it in headers)
      if (!response.ok) {
        const errorDetails = await response.text(); // Extraer información del error
        console.error("Error Details:", errorDetails);
        throw new Error("Error de red: " + response.status + " - " + errorDetails);
      }
  
      if (!response.ok) {
        const errorDetails = await response.text(); // Extraer información del error
        console.error("Error Details:", errorDetails);
        throw new Error("Error de red: " + response.status);
      }
  
      const data = await response.json();
      console.log("Success:", data);
      setShowSuccess(true);
  
      // Check and use "Thank You" URL from FSF_data
      console.log("FSF_data:", FSF_data);
      const thankYouUrl = FSF_data?.thanks_url && FSF_data.thanks_url.startsWith("https")
        ? FSF_data.thanks_url
        : "/";
      console.log("Thank You URL:", thankYouUrl);
  
      setTimeout(() => {
        try {
          // Redirect using window.location.href
          window.location.href = thankYouUrl;
        } catch (navError) {
          console.error("Navigation error:", navError);
        }
      }, 1000);
    } catch (error) {
      console.error("Error:", error);
      //alert("There was an error submitting the quote.");
    }
  };
    
  

  const handleCloseSuccessMessage = () => {
    setShowSuccess(false);
    reset();
    setValue(0);
  };

  useEffect(() => {
    if (showSuccess) scrollToForm();
  }, [showSuccess]);

  useEffect(() => scrollToForm(), []);

  const completedServices = Object.entries(selections).map(([uniqueServiceId, serviceSelections]) => {
    const serviceTitle = serviceSelections.serviceTitle || `Servicio ${uniqueServiceId}`;
    const phases = Object.keys(serviceSelections)
      .filter(phaseId => phaseId !== "serviceTitle")
      .map(phaseId => ({
        phaseId,
        phaseTitle: serviceSelections[phaseId].phaseTitle,
        phaseSelections: serviceSelections[phaseId],
      }));
    return { uniqueServiceId, serviceTitle, phases };
  });

  if (!userData) {
    return (
      <Typography variant="h5" gutterBottom className="heading">
        User information not available. Please re-enter the data.
      </Typography>
    );
  }

  return (
    <>
      {showSuccess && <SuccessMessage onClose={handleCloseSuccessMessage} />}
      <Paper className="form-paper">
        <Box className="summary-form" ref={formRef}>
          <>
            <Logo /> {/* Usando el componente Logo aquí */}
            <Typography variant="h5" gutterBottom className="heading" sx={{ fontFamily: "Poppins, sans-serif", fontWeight: "bold" }}>
              Selections Summary
            </Typography>
            <form onSubmit={handleSubmit(onSubmit)}>
              <TabsComponent
                tabs={completedServices}
                value={value}
                handleChange={handleChange}
                onEditSelections={onEditSelections}
                onAddMoreServicesAndScroll={handleAddMoreServicesAndScroll}
              />
              <Box display="flex" justifyContent="center" sx={{ mt: 1.25, mb: -1.25 }}>
                <Button className="custom-button" type="submit">
                  <span className="icon-btn"></span>
                  <span className="title-btn" data-animate-text="SUBMIT PROPOSAL">SUBMIT PROPOSAL</span>
                </Button>
              </Box>
            </form>
          </>
        </Box>
      </Paper>
    </>
  );
};

export default SummaryForm;
