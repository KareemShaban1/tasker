import useValidationRules from "@/services/ValidationService"

export default function useValidator() {
  const { validateForm, errors, rules } = useValidationRules()

  const validationRules = [
    {
      property: 'title',
      rules: [],
    },
  ]

  const validate = form => {
    return validateForm(form, validationRules)
  }

  return { errors, validate }
}
