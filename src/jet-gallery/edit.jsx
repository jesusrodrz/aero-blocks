import AddButton from '../components/AddButton/AddButton.jsx';
import Add from '../components/AddIcon.jsx';
import Aux from '../components/Aux.jsx';

const { __ } = wp.i18n; // Import __() from wp.i18n
const {
  RichText,
  MediaUpload,
  URLInputButton,
  InspectorControls,
  fr
} = wp.blockEditor;
const {
  Dropdown,
  RadioControl,
  ColorPicker,
  PanelBody,
  RangeControl,
  TextControl
} = wp.components;
function checkClass(varible, className) {
  return varible === true && varible !== undefined ? className : '';
}
const Image = props => {
  return <img className="jet-gallery__img" src={props.url} alt="" />;
};
const Edit = props => {
  const { attributes, setAttributes, isSelected } = props;
  const { images, edit, imagesData } = attributes;

  const classes = [props.className, 'jet-gallery'];
  // console.log(MediaUpload);
  const hasImages = images && images.length > 0 ? true : false;
  return (
    <div>
      <MediaUpload
        onSelect={media => {
          console.log(media);
          // setAttributes({
          //   image: { id: media.id, url: media.url, title: media.title }
          // });
          // const imagesData = media.map(image => ({
          //   id: image.id,
          //   url: image.url,
          //   caption: image.caption
          // }));
          const imagesID = [];
          const imagesNewData = media.map(image => {
            imagesID.push(image.id);
            return {
              id: image.id,
              url: image.url,
              caption: image.caption
            };
          });
          setAttributes({ images: imagesID, imagesData: imagesNewData });
        }}
        title={__('Agrega o modifica las imagenes')}
        gallery
        multiple
        allowedTypes={['image']}
        value={images}
        render={({ open }) => (
          <div className="jet-gallery">
            {hasImages ? (
              <Aux>
                <div className="jet-gallery__panel">
                  <h2 className="jet-gallery__title">
                    {__('Editar Imagenes a la galeria')}
                  </h2>
                  <AddButton className="jet-gallery__btn small" onClick={open}>
                    <i className="i-pencil"></i>
                  </AddButton>
                </div>
                {imagesData.map(image => (
                  <Image key={image.id} url={image.url} />
                ))}
              </Aux>
            ) : (
              <Aux>
                <h2 className="jet-gallery__title">
                  {__('Agregar Imagenes a la galeria')}
                </h2>
                <AddButton className="jet-gallery__btn" onClick={open} />
              </Aux>
            )}
          </div>
        )}
      />
    </div>
  );
};

export default Edit;
