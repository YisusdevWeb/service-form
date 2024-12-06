import React, { useCallback, useEffect, useState } from "react";
import { Box, Typography, CssBaseline } from "@mui/material";
import { useForm, FormProvider } from "react-hook-form";
import { createTheme, ThemeProvider } from "@mui/material/styles";
import useStore from "../store/store.js";
import AlertSnackbar from "../components/AlertSnackbar";
import { handleSelectionFactory } from "../utils/handleSelection";
import AddMoreServicesPopup from "../components/AddMoreServicesPopup";
import SummaryTabs from "../components/SummaryTabs";
import SummaryForm from "./SummaryForm";
import PhaseStepper from "../components/stepform/PhaseStepper";
import PhaseContent from "../components/stepform/PhaseContent";
import FormNavigation from "../components/stepform/FormNavigation";

const theme = createTheme({
  components: {
    MuiStepLabel: {
      styleOverrides: {
        label: {
          display: "none",
        },
      },
    },
  },
});

const StepForm = React.memo(({ onComplete, onServiceComplete }) => {
  const methods = useForm();
  const { handleSubmit, setValue, watch, getValues } = methods;
  const {
    currentService,
    currentPhase,
    setCurrentPhase,
    addSelection,
    selections,
    resetService,
    setCurrentService, // Asegúrate de que este método esté disponible
  } = useStore();
  const [snackbarOpen, setSnackbarOpen] = useState(false);
  const [snackbarMessage, setSnackbarMessage] = useState("");
  const [snackbarSeverity, setSnackbarSeverity] = useState("info");
  const [addMoreServicesPopupOpen, setAddMoreServicesPopupOpen] = useState(false);
  const [showSummary, setShowSummary] = useState(false);
  const [showServiceSummary, setShowServiceSummary] = useState(false);

  const handleSelection = useCallback(
    handleSelectionFactory(
      currentPhase,
      selections,
      (phase, selection) =>
        addSelection(currentService.uniqueId, phase, selection),
      currentService,
      setCurrentPhase,
      setSnackbarMessage,
      setSnackbarSeverity,
      setSnackbarOpen
    ),
    [
      currentPhase,
      selections,
      currentService,
      setCurrentPhase,
      setSnackbarMessage,
      setSnackbarSeverity,
      setSnackbarOpen,
      addSelection,
    ]
  );

  useEffect(() => {
    const currentSelections =
      selections[currentService?.uniqueId]?.[currentPhase];
    if (currentSelections) {
      Object.keys(currentSelections).forEach((option) => {
        setValue(option, currentSelections[option]);
      });
    }
  }, [currentPhase, selections, setValue, currentService]);

  const onSubmit = () => {
    const currentSelections =
      selections[currentService?.uniqueId]?.[currentPhase] || {};
    const isSelected = Object.values(currentSelections).some(
      (value) => value === true
    );

    if (!isSelected) {
      setSnackbarMessage(
        "Debes seleccionar al menos una opción para continuar."
      );
      setSnackbarSeverity("error");
      setSnackbarOpen(true);
      return;
    }

    if (currentPhase < currentService.fases_do_servico.length - 1) {
      setCurrentPhase(currentPhase + 1);
    } else {
      setShowServiceSummary(true);
    }
  };

  const handleConfirmAddMoreServices = () => {
    onServiceComplete(currentService);
    resetService();
    setAddMoreServicesPopupOpen(false);
  };

  const handleCloseAddMoreServicesPopup = () => {
    setAddMoreServicesPopupOpen(false);
    setShowSummary(true);
  };

  const handleStepClick = (step) => {
    if (step <= currentPhase) {
      setCurrentPhase(step);
    }
  };

  const handleCloseSnackbar = () => {
    setSnackbarOpen(false);
  };

  const handleShowServiceSummary = () => {
    setShowServiceSummary(true);
  };

  const handleAddMoreServices = () => {
    setShowServiceSummary(false);
    setAddMoreServicesPopupOpen(true);
  };

  const handleEditSelections = () => { setShowServiceSummary(false); setShowSummary(false); };

  const handleDeclineAddMoreServices = () => {
    setAddMoreServicesPopupOpen(false);
    setShowSummary(true);
  };

  const handleContinueQuote = () => {
    // Lógica para continuar con la cotización
    console.log("Continuando con la cotización...");
    setShowSummary(true);
    setShowServiceSummary(false);
  };
  

  return (
    <ThemeProvider theme={theme}>
      <CssBaseline />
      {showSummary ? (
        <SummaryForm />
      ) : showServiceSummary ? (
        <SummaryTabs
          onEditSelections={handleEditSelections}
          onAddMoreServices={handleAddMoreServices}
          onContinueQuote={handleContinueQuote}
          
        />
      ) : (
        <FormProvider {...methods}>
          <Box>
            <Typography
              variant="h4"
              gutterBottom
              sx={{ color: "#0f4c80", textAlign: "center", fontWeight: "bold" }}
            >
              {currentService.titulo}
            </Typography>
            <PhaseStepper
              currentPhase={currentPhase}
              fases={Array.isArray(currentService.fases_do_servico) ? currentService.fases_do_servico : []}
              onStepClick={handleStepClick}
            />
            <Typography sx={{ textAlign: "center", mb: 2 }}>
              Paso {currentPhase + 1} de{" "}
              {currentService.fases_do_servico.length}
            </Typography>
            <PhaseContent
              fase={currentService.fases_do_servico[currentPhase]}
              handleSelection={handleSelection}
              watch={watch}
              getValues={getValues}
            />
            <FormNavigation
              currentPhase={currentPhase}
              totalPhases={currentService.fases_do_servico.length}
              onPrevious={() => setCurrentPhase(currentPhase - 1)}
              onNext={handleSubmit(onSubmit)}
            />
            <AlertSnackbar
              open={snackbarOpen}
              message={snackbarMessage}
              severity={snackbarSeverity}
              onClose={handleCloseSnackbar}
            />
            <AddMoreServicesPopup
              open={addMoreServicesPopupOpen}
              onClose={handleDeclineAddMoreServices}
              onConfirm={handleConfirmAddMoreServices}
            />
          </Box>
        </FormProvider>
      )}
    </ThemeProvider>
  );
});

export default StepForm;
