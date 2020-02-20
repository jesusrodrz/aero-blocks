const sections = [...document.querySelectorAll('.section-customers')];
function setCustomersModal() {
  const modalContainer = document.createElement('div');
  modalContainer.classList.add('modal-customers');
  modalContainer.innerHTML = `
    <div class="modal-customers__card">
      <button class="modal-customers__close">×</button>
      <div class="modal-customers__content"></div>
    </div>
  `;
  document.body.appendChild(modalContainer);
  document.addEventListener('click', e => {
    const logoBtn = e.target.closest('.section-customer');
    const closeBtn = e.target.closest('.modal-customers__close');
    if (logoBtn) {
      const dataID = logoBtn.getAttribute('data-id');
      openModal(modalContainer, dataID);
    }
    if (closeBtn) {
      closeModal(modalContainer);
    }
  });
  // modalContainer.classList.add('active');
}
setCustomersModal();
function openModal(modalContainer, dataID) {
  const modalContent = modalContainer.querySelector(
    '.modal-customers__content'
  );
  modalContent.innerHTML = '';
  const content = document.getElementById(dataID).cloneNode(true);
  modalContent.appendChild(content);
  modalContainer.classList.add('active');
  document.body.classList.add('body-overflow-hidden');
}
function closeModal(modalContainer) {
  modalContainer.classList.remove('active');
  document.body.classList.remove('body-overflow-hidden');
}
