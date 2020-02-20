const { __ } = wp.i18n; // Import __() from wp.i18n
const {
  RichText,
  MediaUpload,
  URLInputButton,
  InspectorControls
} = wp.blockEditor;
const {
  RadioControl,
  ColorPicker,
  PanelBody,
  RangeControl,
  TextControl,
  Tooltip,
  Button
} = wp.components;
function checkClass(varible, className) {
  return varible === true && varible !== undefined ? className : '';
}
const Edit = props => {
  const { attributes, setAttributes, isSelected } = props;
  const { title, logo, images, content, imageIDs, hasImages } = attributes;
  const logoID = logo.id;
  // const imagesIDs = images && images.lenght > 0 ? images : null;
  const classes = ['customer'].join(' ');
  const classesLogoCantainer = [
    'customer__logo-container',
    checkClass(logoID && true, 'has-image')
  ].join(' ');
  const classesImagesCantainer = [
    'customer__images',
    checkClass(hasImages, 'has-image')
  ].join(' ');

  return (
    <div className={classes} style={{}}>
      <MediaUpload
        onSelect={media => {
          const newImage = { id: media.id, url: media.url, title: media.title };
          setAttributes({
            logo: newImage
          });
        }}
        title={__('Selecciona un logo')}
        allowedTypes={['image']}
        value={logoID}
        render={({ open }) => (
          <div className={classesLogoCantainer}>
            {logoID && (
              <img
                className="customer__logo-img"
                src={logo.url}
                alt={logo.title}
              />
            )}
            <Button
              className="customer__logo-btn"
              isSecondary
              isLarge
              onClick={open}
            >
              {__('Eligue o cambia el logo')}
            </Button>
          </div>
        )}
      />

      <RichText
        className="customer__title"
        value={title}
        onChange={value => setAttributes({ title: value })}
        placeholder={__('Nombre de la Empresa')}
      />
      <RichText
        className="customer__content"
        value={content}
        onChange={value => setAttributes({ content: value })}
        placeholder={__('Agrega la descripcion')}
      />
      <MediaUpload
        onSelect={media => {
          const IDs = [];
          const newImages = media
            .filter((media, i) => i < 4)
            .map(img => {
              IDs.push(img.id);
              return { id: img.id, url: img.url, title: img.caption };
            });
          console.log(newImages);
          setAttributes({
            images: newImages,
            imageIDs: IDs,
            hasImages: true
          });
        }}
        allowedTypes={['image']}
        multiple
        title={__('Selecciona Maximo 4 imagenes')}
        gallery
        value={imageIDs}
        render={({ open }) => (
          <div className={classesImagesCantainer}>
            {hasImages &&
              images.map(image => (
                <img
                  key={image.id}
                  className="customer__image"
                  src={image.url}
                  alt={image.title}
                />
              ))}
            <Tooltip text={__('Maximo 4 imagenes')}>
              <Button
                className="customer__logo-btn customer__images-btn"
                isSecondary
                isLarge
                onClick={open}
              >
                {__('Agrega imagenes')}
              </Button>
            </Tooltip>
          </div>
        )}
      />
    </div>
  );
};

export default Edit;
