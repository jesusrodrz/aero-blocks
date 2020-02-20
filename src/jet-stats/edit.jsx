import Add from './../components/AddIcon.jsx';
import Icon from './../components/Icon.jsx';

const { __ } = wp.i18n; // Import __() from wp.i18n
const {
  RichText,
  MediaUpload,
  URLInputButton,
  InspectorControls
} = wp.blockEditor;
const {
  Dropdown,
  RadioControl,
  ColorPicker,
  PanelBody,
  RangeControl,
  TextControl,
  Tooltip
} = wp.components;
function checkClass(varible, className) {
  return varible === true && varible !== undefined ? className : '';
}

const icons = [
  'i-pencil',
  'i-pencil2',
  'i-image',
  'i-images',
  'i-connection',
  'i-pushpin',
  'i-location',
  'i-compass2',
  'i-clock',
  'i-alarm',
  'i-stopwatch',
  'i-user-tie',
  'i-enlarge2',
  'i-shrink2',
  'i-meter',
  'i-airplane',
  'i-list2',
  'i-earth',
  'i-sort-amount-asc',
  'i-safari',
  'i-checkmark',
  'i-checkmark2'
];
const Stat = props => {
  return (
    <div className="jet-stat">
      <div className="jet-stat__icon">
        <Dropdown
          className="my-container-class-name"
          contentClassName="my-popover-content-classname"
          position="bottom right"
          renderToggle={({ isOpen, onToggle }) => (
            <Tooltip text={__('Cambiar Icono')}>
              <button
                className="jet-stat__icon-btn"
                onClick={onToggle}
                aria-expanded={isOpen}
              >
                <i className={props.stat.icon}></i>
              </button>
            </Tooltip>
          )}
          renderContent={({ isOpen, onToggle }) => (
            <div className="jet-stats__dropdown">
              {icons.map((icon, i) => (
                <button
                  key={i}
                  className={[
                    'jet-stats__dropdown-btn',
                    props.stat.icon === icon ? 'active' : ''
                  ].join(' ')}
                  onClick={() => {
                    props.changeIcon(icon);
                    onToggle();
                  }}
                >
                  <Icon icon={icon} />
                </button>
              ))}
            </div>
          )}
        />
      </div>
      <RichText
        className="jet-stat__text"
        value={props.stat.text}
        onChange={props.changeText}
        placeholder={__('Descripción...')}
      />
      <Tooltip text={__('Eliminar')}>
        <button className="jet-stat__delete" onClick={props.delete}>
          <Add />
        </button>
      </Tooltip>
      <Tooltip text={__('Selecionar para mostrar')}>
        <button
          className={[
            'jet-stat__select',
            checkClass(props.stat.selected, 'active')
          ].join(' ')}
          onClick={props.select}
        >
          <i
            className={props.stat.selected ? 'i-checkmark' : 'i-checkmark2'}
          ></i>
        </button>
      </Tooltip>
    </div>
  );
};

const Edit = props => {
  const { attributes, setAttributes } = props;
  const { stats, stat } = attributes;

  const classes = [props.className, 'jet-stats'];
  const statDefault = {
    icon: 'i-pencil',
    text: null
  };

  const handleChange = (type, value, index) => {
    let isSelected;
    const newStast = stats.map((stat, i) => {
      if (index !== i) {
        return stat;
      }
      const newStat = { ...stat };
      isSelected = stat.selected ? newStat : null;
      newStat[type] = value;
      return newStat;
    });
    if (isSelected) {
      setAttributes({ stats: newStast, stat: isSelected });
    } else {
      setAttributes({ stats: newStast });
    }
  };
  const handleDelete = index => {
    const newStast = stats.filter((statItem, i) =>
      i === index ? false : statItem
    );
    setAttributes({ stats: newStast });
  };
  const handleSelect = index => {
    const newStats = stats.map((item, i) => {
      const newStat = { ...item };
      if (index === i && item.key !== stat.key) {
        newStat.selected = true;
      } else {
        newStat.selected = false;
      }

      return newStat;
    });
    const statItem = newStats.find(item => item.selected === true);

    setAttributes({ stats: newStats, stat: statItem || { key: null } });
  };
  return (
    <div className={classes.join(' ')}>
      {stats.map((stat, i) => (
        <Stat
          key={i}
          stat={stat}
          changeIcon={value => handleChange('icon', value, i)}
          changeText={value => handleChange('text', value, i)}
          delete={() => handleDelete(i)}
          select={() => handleSelect(i)}
        />
      ))}
      <button
        className="jet-stats__add"
        onClick={() => {
          const newStats = [...stats];
          const newStat = {
            ...statDefault,
            key: Math.round(Math.random() * 10000)
          };
          newStats.push(newStat);
          setAttributes({ stats: newStats });
        }}
      >
        <Add />
      </button>
    </div>
  );
};

export default Edit;
