/**
 * Form Handling JavaScript
 * Handles multi-step forms and AJAX submissions
 */

document.addEventListener("DOMContentLoaded", function () {
  // Localize script data
  const romonetForms = {
    ajaxUrl:
      typeof romonetFormsData !== "undefined"
        ? romonetFormsData.ajaxUrl
        : "/wp-admin/admin-ajax.php",
    nonce: typeof romonetFormsData !== "undefined" ? romonetFormsData.nonce : ""
  }

  function createToastController(noticeSelector, closeSelector) {
    const notice = document.querySelector(noticeSelector)
    if (!notice) {
      return null
    }

    const messageEl = notice.querySelector("[data-romonet-toast-message]")
    const trackingWrap = notice.querySelector("[data-romonet-toast-tracking]")
    const trackingCodeEl = notice.querySelector(
      "[data-romonet-toast-tracking-code]"
    )
    const panelEl = notice.querySelector("[data-romonet-toast-panel]")
    const closeButton = notice.querySelector(closeSelector)
    let hideTimer = null

    function hide() {
      notice.classList.add("hidden")
    }

    function show(options) {
      const message = options.message || ""
      const trackingCode = options.trackingCode || ""
      const type = options.type || "success"

      if (messageEl) {
        messageEl.textContent = message
      }

      if (trackingWrap && trackingCodeEl) {
        if (trackingCode) {
          trackingCodeEl.textContent = trackingCode
          trackingWrap.classList.remove("hidden")
        } else {
          trackingCodeEl.textContent = ""
          trackingWrap.classList.add("hidden")
        }
      }

      if (panelEl) {
        panelEl.classList.remove(
          "ring-red-200",
          "ring-green-200",
          "ring-slate-200"
        )
        panelEl.classList.add(
          type === "error" ? "ring-red-200" : "ring-green-200"
        )
      }

      notice.classList.remove("hidden")

      if (hideTimer) {
        clearTimeout(hideTimer)
      }

      hideTimer = window.setTimeout(hide, type === "error" ? 6000 : 8000)
    }

    if (closeButton) {
      closeButton.addEventListener("click", hide)
    }

    return { show, hide }
  }

  const formToast = createToastController(
    "[data-romonet-form-notice]",
    "[data-romonet-form-notice-close]"
  )

  function resetInlineMessage(messageDiv) {
    if (!messageDiv) {
      return
    }

    messageDiv.classList.add("hidden")
    messageDiv.classList.remove(
      "bg-green-100",
      "text-green-700",
      "bg-red-100",
      "text-red-700"
    )
    messageDiv.textContent = ""
  }

  function showInlineError(messageDiv, message) {
    if (!messageDiv) {
      return
    }

    messageDiv.classList.remove("hidden", "bg-green-100", "text-green-700")
    messageDiv.classList.add("bg-red-100", "text-red-700")
    messageDiv.textContent = message
  }

  function showFormSuccess(message, trackingCode) {
    resetInlineMessage(document.getElementById("contact-form-message"))
    resetInlineMessage(document.getElementById("project-form-message"))

    if (formToast) {
      formToast.show({
        message: message,
        trackingCode: trackingCode,
        type: "success"
      })
    }
  }

  // Multi-step form functionality
  const projectForm = document.getElementById("project-request-form")
  if (projectForm) {
    const formWrapper = projectForm.parentElement
    const steps = projectForm.querySelectorAll(".form-step")
    const stepIndicators = formWrapper.querySelectorAll(".step-indicator")
    const progressBars = formWrapper.querySelectorAll(".progress-bar")
    let currentStep = 1
    const totalSteps = steps.length

    // Update progress indicators
    function updateProgress(step) {
      stepIndicators.forEach((indicator, index) => {
        const stepNum = index + 1
        const label = indicator.nextElementSibling

        if (stepNum <= step) {
          indicator.classList.remove("bg-slate-200", "text-slate-600")
          indicator.classList.add("bg-pink-600", "text-white")
          if (label) {
            label.classList.remove("text-slate-600")
            label.classList.add("text-pink-600")
          }
        } else {
          indicator.classList.remove("bg-pink-600", "text-white")
          indicator.classList.add("bg-slate-200", "text-slate-600")
          if (label) {
            label.classList.remove("text-pink-600")
            label.classList.add("text-slate-600")
          }
        }
      })

      progressBars.forEach((bar, index) => {
        const barStep = index + 1
        if (barStep < step) {
          bar.style.width = "100%"
        } else if (barStep === step) {
          bar.style.width = "50%"
        } else {
          bar.style.width = "0%"
        }
      })
    }

    // Show specific step
    function showStep(step) {
      steps.forEach((stepEl, index) => {
        const stepNum = index + 1
        if (stepNum === step) {
          stepEl.classList.remove("hidden")
          stepEl.classList.add("active")
        } else {
          stepEl.classList.add("hidden")
          stepEl.classList.remove("active")
        }
      })
      updateProgress(step)
      currentStep = step
    }

    // Validate current step
    function validateStep(step) {
      const currentStepEl = document.querySelector(
        `.form-step[data-step="${step}"]`
      )
      const requiredFields = currentStepEl.querySelectorAll("[required]")
      let isValid = true

      requiredFields.forEach(field => {
        if (!field.value.trim()) {
          field.classList.add("border-red-500")
          isValid = false
        } else {
          field.classList.remove("border-red-500")
        }

        // Email validation
        if (field.type === "email" && field.value) {
          const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
          if (!emailRegex.test(field.value)) {
            field.classList.add("border-red-500")
            isValid = false
          }
        }
      })

      return isValid
    }

    // Next step button
    projectForm.querySelectorAll(".next-step-btn").forEach(btn => {
      btn.addEventListener("click", function (e) {
        e.preventDefault()
        if (validateStep(currentStep) && currentStep < totalSteps) {
          showStep(currentStep + 1)
        } else if (!validateStep(currentStep)) {
          // Shake animation for invalid fields
          const currentStepEl = document.querySelector(
            `.form-step[data-step="${currentStep}"]`
          )
          currentStepEl.classList.add("animate-pulse")
          setTimeout(() => {
            currentStepEl.classList.remove("animate-pulse")
          }, 500)
        }
      })
    })

    // Previous step button
    projectForm.querySelectorAll(".prev-step-btn").forEach(btn => {
      btn.addEventListener("click", function (e) {
        e.preventDefault()
        if (currentStep > 1) {
          showStep(currentStep - 1)
        }
      })
    })

    updateProgress(1)

    // Form submission
    projectForm.addEventListener("submit", function (e) {
      e.preventDefault()

      if (!validateStep(currentStep)) {
        return
      }

      const submitBtn = projectForm.querySelector('button[type="submit"]')
      const messageDiv = document.getElementById("project-form-message")

      submitBtn.disabled = true
      submitBtn.textContent = "در حال ارسال..."

      // Collect form data
      const formData = new FormData(projectForm)
      formData.append("action", "romonet_submit_project_form")
      formData.append("nonce", romonetForms.nonce)

      // Handle checkboxes
      const features = []
      projectForm
        .querySelectorAll('input[name="features[]"]:checked')
        .forEach(checkbox => {
          features.push(checkbox.value)
        })
      formData.delete("features[]")
      features.forEach(feature => {
        formData.append("features[]", feature)
      })

      fetch(romonetForms.ajaxUrl, {
        method: "POST",
        body: formData
      })
        .then(response => response.text())
        .then(text => {
          try {
            const data = JSON.parse(text)
            if (data.success) {
              showFormSuccess(data.data.message, data.data.tracking_code)
              projectForm.reset()
              showStep(1)
            } else {
              showInlineError(messageDiv, data.data.message)
            }
          } catch (e) {
            showInlineError(
              messageDiv,
              "خطا در پردازش پاسخ سرور. لطفاً دوباره تلاش کنید."
            )
            console.error("JSON Parse Error:", e)
            console.error("Response text:", text)
          }
        })
        .catch(error => {
          showInlineError(
            messageDiv,
            "خطا در ارتباط با سرور. لطفاً دوباره تلاش کنید."
          )
          console.error("Error:", error)
        })
        .finally(() => {
          submitBtn.disabled = false
          submitBtn.textContent = "ارسال درخواست"
        })
    })
  }

  // Contact form submission
  const contactForm = document.getElementById("contact-form")
  if (contactForm) {
    contactForm.addEventListener("submit", function (e) {
      e.preventDefault()

      const submitBtn = contactForm.querySelector('button[type="submit"]')
      const messageDiv = document.getElementById("contact-form-message")

      submitBtn.disabled = true
      submitBtn.textContent = "در حال ارسال..."

      // Collect form data
      const formData = new FormData(contactForm)
      formData.append("action", "romonet_submit_contact_form")
      formData.append("nonce", romonetForms.nonce)

      fetch(romonetForms.ajaxUrl, {
        method: "POST",
        body: formData
      })
        .then(response => response.text())
        .then(text => {
          try {
            const data = JSON.parse(text)
            if (data.success) {
              showFormSuccess(data.data.message, data.data.tracking_code)
              contactForm.reset()
            } else {
              showInlineError(messageDiv, data.data.message)
            }
          } catch (e) {
            showInlineError(
              messageDiv,
              "خطا در پردازش پاسخ سرور. لطفاً دوباره تلاش کنید."
            )
            console.error("JSON Parse Error:", e)
            console.error("Response text:", text)
          }
        })
        .catch(error => {
          showInlineError(
            messageDiv,
            "خطا در ارتباط با سرور. لطفاً دوباره تلاش کنید."
          )
          console.error("Error:", error)
        })
        .finally(() => {
          submitBtn.disabled = false
          submitBtn.textContent = "ارسال درخواست"
        })
    })
  }

  function showNewsletterMessage(form, type, message) {
    const messageDiv = form.querySelector('[id$="-message"]')
    if (!messageDiv) {
      return
    }

    messageDiv.classList.remove(
      "hidden",
      "bg-green-500/15",
      "text-green-200",
      "bg-red-500/15",
      "text-red-200"
    )

    if (type === "success") {
      messageDiv.classList.add("bg-green-500/15", "text-green-200")
    } else {
      messageDiv.classList.add("bg-red-500/15", "text-red-200")
    }

    messageDiv.textContent = message
  }

  function validateNewsletterForm(form) {
    const fieldsMode =
      form.querySelector('[name="fields_mode"]')?.value || "email"
    const emailField = form.querySelector('[name="email"]')
    const phoneField = form.querySelector('[name="phone"]')
    const consentField = form.querySelector('[name="consent"]')
    let isValid = true

    if (emailField) {
      emailField.classList.remove("border-red-400")
    }

    if (phoneField) {
      phoneField.classList.remove("border-red-400")
    }

    if ((fieldsMode === "email" || fieldsMode === "both") && emailField) {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
      if (
        !emailField.value.trim() ||
        !emailRegex.test(emailField.value.trim())
      ) {
        emailField.classList.add("border-red-400")
        isValid = false
      }
    }

    if ((fieldsMode === "phone" || fieldsMode === "both") && phoneField) {
      const phoneDigits = phoneField.value.replace(/\D+/g, "")
      if (!phoneDigits || phoneDigits.length < 10) {
        phoneField.classList.add("border-red-400")
        isValid = false
      }
    }

    if (consentField && !consentField.checked) {
      isValid = false
    }

    return isValid
  }

  document
    .querySelectorAll('[data-form-type="newsletter"]')
    .forEach(newsletterForm => {
      newsletterForm.addEventListener("submit", function (e) {
        e.preventDefault()

        const submitBtn = newsletterForm.querySelector('button[type="submit"]')
        const submitLabel = newsletterForm.querySelector(
          "[data-newsletter-submit-label]"
        )
        const defaultLabel = submitLabel ? submitLabel.textContent : "عضویت"

        if (!validateNewsletterForm(newsletterForm)) {
          showNewsletterMessage(
            newsletterForm,
            "error",
            "لطفاً اطلاعات را به‌درستی وارد کنید."
          )
          return
        }

        submitBtn.disabled = true
        if (submitLabel) {
          submitLabel.textContent = "در حال ثبت..."
        }

        const formData = new FormData(newsletterForm)
        formData.append("action", "romonet_submit_newsletter_form")
        formData.append("nonce", romonetForms.nonce)

        fetch(romonetForms.ajaxUrl, {
          method: "POST",
          body: formData
        })
          .then(response => response.text())
          .then(text => {
            try {
              const data = JSON.parse(text)
              if (data.success) {
                showNewsletterMessage(
                  newsletterForm,
                  "success",
                  data.data.message
                )
                newsletterForm.reset()
              } else {
                showNewsletterMessage(
                  newsletterForm,
                  "error",
                  data.data.message
                )
              }
            } catch (error) {
              showNewsletterMessage(
                newsletterForm,
                "error",
                "خطا در پردازش پاسخ سرور. لطفاً دوباره تلاش کنید."
              )
              console.error("JSON Parse Error:", error)
              console.error("Response text:", text)
            }
          })
          .catch(error => {
            showNewsletterMessage(
              newsletterForm,
              "error",
              "خطا در ارتباط با سرور. لطفاً دوباره تلاش کنید."
            )
            console.error("Error:", error)
          })
          .finally(() => {
            submitBtn.disabled = false
            if (submitLabel) {
              submitLabel.textContent = defaultLabel
            }
          })
      })
    })

  // Remove error styling on input
  document.querySelectorAll("input, select, textarea").forEach(field => {
    field.addEventListener("input", function () {
      this.classList.remove("border-red-500", "border-red-400")
    })
  })
})
