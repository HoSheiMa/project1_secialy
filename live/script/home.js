$.ajax({
	url: '../ajax.php',
	type: 'post',
	data: {
		req: 'live_rooms'
	},
	success: (d) => {
		d = JSON.parse(d);
		name = d[0];
		id_room = d[1];
		img = d[2];


		// d => array json
		for (i in d) {
			name = d[i][0];
			id_room = d[i][1];
			img = d[i][2];
			txt = d[i][3];
			img_l = d[i][4];

			throw_alert({
				room: {
					type: 'section',
					children: {
						img: {

							type: 'img',
							attr: {
								src: img_l,
								width: 300,
								height: 300,
							},

						},
						owner: {
							html: `Id live :${id_room}<br><img src=data:image/png;base64,${img} width=40>`,
							children: {
								name : {
									type : 'span',
									text : `${name}`,
									attr : {
										style : {
											position: 'relative',
										    top: '-15px',
										    borderBottom:' 1px solid',
										}
									}
								},
								br : {type : 'br'},
								txt: {
									html: `${txt}`,
									attr: {
										style: {
											boxShadow: '0 0 3px',
											padding: '8px',
											borderRadius: '6px',
											margin: '0px 0px 10px 0px',
										}
									}
								},
								btn_herf: {
									type: 'button',
									text: 'See',
									events: {
										onclick: () => {
											window.location.href = `http://localhost/live/?room=${id_room}`
										}
									},
									attr: {
										style: {
											width: '100%',
											display: 'block',
											border: ' 1px solid',
											padding: '6px',
											cursor: 'pointer',
											borderRadius: '5px',
											color: '#000',
											backgroundColor: 'transparent',
											borderColor: '#db49d8',
										}
									}
								}
							}
						}
					},
					attr: {
						style: {
							display: 'inline-block',
							padding: '8px',
							margin: '2px',
							background: 'white',
							borderRadius: '6px',
							color: 'rebeccapurple',
							boxShadow: '0 0 3px',

						}
					}
				}
			}, $('.room_show'), true);

		}

	}
})