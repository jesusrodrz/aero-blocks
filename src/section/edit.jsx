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
  TextControl
} = wp.components;
function checkClass(varible, className) {
  return varible === true && varible !== undefined ? className : '';
}
console.log(wp.components);
const Edit = props => {
  const { attributes, setAttributes, isSelected } = props;
  const {
    title,
    content,
    image,
    link,
    isRight,
    isBottom,
    hideTitle,
    hideContent,
    hideLink,
    bgColor,
    noPadding,
    vAlignment,
    imgHeight,
    sectionID
  } = attributes;
  const imageID = image ? image.id : null;
  const linkTitle = link ? link.title : null;
  const linkUlr = link ? link.url : null;

  const classes = `${props.className} mensajes ${isSelected &&
    'focus'} ${checkClass(isRight, 'right')} ${checkClass(noPadding, 'no-pd')}`;

  console.log(imgHeight);
  return (
    <div
      className={classes}
      style={{
        '--bg-color': bgColor,
        '--v-alingment': vAlignment,
        '--img-height': `${imgHeight}%`
      }}
    >
      <InspectorControls>
        <PanelBody title={__('Opciones de la sección')} initialOpen={false}>
          <div className="components-base-control__field">
            <label
              className="components-base-control__label"
              htmlFor="inspector-radio-control-0"
            >
              {__('Color de fondo')}
            </label>
            <ColorPicker
              color={bgColor}
              onChangeComplete={value => {
                const { r, g, b, a } = value.rgb;
                const rgba = `rgba(${r},${g},${b},${a})`;
                setAttributes({ bgColor: rgba });
              }}
            />
          </div>
          <RadioControl
            label={__('Ocultar titlulo')}
            selected={hideTitle}
            options={[
              { label: __('Si'), value: true },
              { label: __('No'), value: false }
            ]}
            onChange={value => {
              setAttributes({ hideTitle: JSON.parse(value.toLowerCase()) });
            }}
          />
          <RadioControl
            label={__('Ocultar contenido')}
            selected={hideContent}
            options={[
              { label: __('Si'), value: true },
              { label: __('No'), value: false }
            ]}
            onChange={value => {
              setAttributes({ hideContent: JSON.parse(value.toLowerCase()) });
            }}
          />
          <RadioControl
            label={__('Ocultar link')}
            selected={hideLink}
            options={[
              { label: __('Si'), value: true },
              { label: __('No'), value: false }
            ]}
            onChange={value => {
              setAttributes({ hideLink: JSON.parse(value.toLowerCase()) });
            }}
          />
          <TextControl
            label={__('ID de la sección')}
            value={sectionID}
            onChange={value => setAttributes({ sectionID: value })}
          />
        </PanelBody>
        <PanelBody title={__('Opciones de la imagen')} initialOpen={false}>
          <RadioControl
            label={__('Ubicación (pantallas grandes)')}
            selected={isRight}
            options={[
              { label: __('Izquierda'), value: false },
              { label: __('Derecha'), value: true }
            ]}
            onChange={value => {
              setAttributes({ isRight: JSON.parse(value.toLowerCase()) });
            }}
          />
          <RadioControl
            label={__('Ubicación (pantallas pequeñas)')}
            selected={isBottom}
            options={[
              { label: __('Arriba'), value: false },
              { label: __('Abajo'), value: true }
            ]}
            onChange={value => {
              setAttributes({ isBottom: JSON.parse(value.toLowerCase()) });
            }}
          />
          <RadioControl
            label={__('Margen')}
            selected={noPadding}
            options={[
              { label: __('Si'), value: false },
              { label: __('No'), value: true }
            ]}
            onChange={value => {
              setAttributes({ noPadding: JSON.parse(value.toLowerCase()) });
            }}
          />
          <RadioControl
            label={__('Alineado Vertical')}
            selected={vAlignment}
            options={[
              { label: __('Arriba'), value: 'baseline' },
              { label: __('Centro'), value: 'center' },
              { label: __('Abajo'), value: 'end' }
            ]}
            onChange={value => {
              setAttributes({ vAlignment: value });
            }}
          />
          <RangeControl
            label={__('Tamaño de la imagen')}
            help={__(
              'Tamaño en porcetanje en relacion al alto de la pantalla...'
            )}
            value={imgHeight}
            onChange={value => setAttributes({ imgHeight: value })}
            min={20}
            max={100}
          />
        </PanelBody>
      </InspectorControls>
      <MediaUpload
        onSelect={media => {
          setAttributes({
            image: { id: media.id, url: media.url, title: media.title }
          });
        }}
        allowedTypes={['image']}
        value={imageID}
        render={({ open }) => (
          <div
            className={`mensajes__img-placeholder ${checkClass(
              isBottom,
              'last'
            )} ${checkClass(image, 'no-bg')}`}
          >
            {image && (
              <img
                className={`mensajes__img ${checkClass(isBottom, 'last')}`}
                src={image.url}
                alt={image.title}
              />
            )}
            <button className="mensajes__img-btn" onClick={open}>
              {__('Seleccionar Imagen')}
            </button>
          </div>
        )}
      />
      {hideTitle || (
        <RichText
          className="mensajes__title"
          value={title}
          allowedFormats={['bold', 'italic']}
          onChange={value => setAttributes({ title: value })}
          placeholder={__('Titulo de la sección...')}
        />
      )}
      {hideContent || (
        <RichText
          className="mensajes__content"
          value={content}
          multiline
          allowedFormats={[]}
          onChange={value => setAttributes({ content: value })}
          placeholder={__('Contenido de la sección...')}
        />
      )}
      {hideLink || (
        <div className="mensajes__link">
          <RichText
            value={linkTitle}
            allowedFormats={[]}
            onChange={value =>
              setAttributes({ link: { ...link, title: value } })
            }
            placeholder={__('Nombre...')}
          />{' '}
          <URLInputButton
            className="mensajes__link-url"
            url={linkUlr}
            onChange={(url, post) => setAttributes({ link: { ...link, url } })}
          />
        </div>
      )}
    </div>
  );
};

export default Edit;
