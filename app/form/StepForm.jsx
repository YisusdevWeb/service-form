import React, { useCallback, useEffect, useState } from "react";
import { Box, Typography, CssBaseline } from "@mui/material";
import { useForm, FormProvider } from "react-hook-form";
import { createTheme, ThemeProvider } from "@mui/material/styles";
import useStore from "../store/store.js";
import AlertSnackbar from "../components/AlertSnackbar";
import { handleSelectionFactory } from "../utils/handleSelection";
import AddMoreServicesPopup from "../components/AddMoreServicesPopup";
import SummaryForm from "./SummaryForm";  // Asegúrate de mantener esta importación
import PhaseStepper from "../components/stepform/PhaseStepper";
import PhaseContent from "../components/stepform/PhaseContent";
import FormNavigation from "../components/stepform/FormNavigation";
import '../../assets/scss/styles.scss'; 

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
const StepForm = React.memo(({ onComplete, onServiceComplete, userData }) => {
  const methods = useForm();
  const { handleSubmit, setValue, watch, getValues } = methods;
  const {
    currentService,
    currentPhase,
    setCurrentPhase,
    addSelection,
    selections,
    resetService,
    setCurrentService,
  } = useStore();
  const [snackbarOpen, setSnackbarOpen] = useState(false);
  const [snackbarMessage, setSnackbarMessage] = useState("");
  const [snackbarSeverity, setSnackbarSeverity] = useState("info");
  const [addMoreServicesPopupOpen, setAddMoreServicesPopupOpen] =
    useState(false);
  const [showSummary, setShowSummary] = useState(false);
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
        "É necessário selecionar pelo menos uma opção para continuar."
      );
      setSnackbarSeverity("error");
      setSnackbarOpen(true);
      return;
    }

    const isLastPhase = currentPhase === currentService.fases_do_servico.length - 1;
    const isLastPhaseUnique = isLastPhase && currentService.fases_do_servico[currentPhase]?.tipo_selecao === 'unica';

    if (isLastPhaseUnique) {
      // Si el último paso es de tipo 'unica', concluye el formulario sin avanzar
      setShowSummary(true);
    } else if (currentPhase < currentService.fases_do_servico.length - 1) {
      setCurrentPhase(currentPhase + 1);
    } else {
      setShowSummary(true);
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

  const handleAddMoreServices = () => {
    setShowSummary(false);
    setAddMoreServicesPopupOpen(true);
  };

  const handleEditSelections = () => {
    setShowSummary(false);
  };
  return (
    <ThemeProvider theme={theme}>
      <CssBaseline />
      {showSummary ? (
        <SummaryForm 
          onEditSelections={handleEditSelections}
          onAddMoreServices={handleAddMoreServices}
          userData={userData}
        />
      ) : (
        <FormProvider {...methods}>
          <Box>
            <Typography
              variant="h4"
              gutterBottom
              sx={{ fontFamily: 'Poppins, sans-serif', color: 'var(--heading-color)', textAlign: 'center', fontWeight: 'bold,' }}
            >
              {currentService.titulo}
            </Typography>
            <PhaseStepper
              currentPhase={currentPhase}
              fases={Array.isArray(currentService.fases_do_servico) ? currentService.fases_do_servico : []}
              onStepClick={handleStepClick}
            />
            <Typography sx={{ fontFamily: 'Poppins, sans-serif', color: 'var(--heading-color)', textAlign: "center", mb: 2 }}>
               {currentPhase + 1} de{" "}
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
              onClose={handleCloseAddMoreServicesPopup}
              onConfirm={handleConfirmAddMoreServices}
            />
          </Box>
        </FormProvider>
      )}
    </ThemeProvider>
  );
});

export default StepForm;
